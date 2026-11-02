// Plain-JS port of Figma's shader runtime (`ShaderEffect.tsx` + `useShaderRuntime.ts`).
// The React hooks are replaced by a small class; render, texture and HTML-in-Canvas logic
// is unchanged. See https://github.com/WICG/html-in-canvas for the canvas API it relies on.
// Classic script (load after webgpu.js) so the page also works when opened from file://.
(() => {

const { acquireDevice } = window.ShaderRuntime

const DEFAULT_MANIFEST = {
  version: 2,
  isAnimated: false,
  usesMouse: false,
  name: '',
}

class RuntimeState {
  constructor(gpu, input) {
    this.gpu = gpu
    this.input = input
    this.output = null
    this.shaderData = []
    // An array of 2 textures that we alternate between for rendering multiple shaders
    // in sequence.
    this.intermediateTextures = []
    this._time = 0
    this._deltaTime = 0
    this._frame = 0
    this._mousePosition = { x: 0, y: 0, down: false }
    // Driven by each shader's manifest (see DEFAULT_MANIFEST); set when effects are applied.
    this.isAnimated = false
    this.usesMouse = false
  }

  getShaderState(index) {
    const renderScale = window.devicePixelRatio || 1
    return {
      gpu: this.gpu,
      input: index === 0 ? this.input : this.intermediateTextures[index % 2],
      output:
        index === this.shaderData.length - 1
          ? this.output
          : this.intermediateTextures[(index + 1) % 2],
      time: this._time,
      deltaTime: this._deltaTime,
      frame: this._frame,
      mousePosition: this._mousePosition,
      renderScale,
      params: this.shaderData[index].shader.params,
      state: this.shaderData[index].state,
    }
  }

  createIntermediateTexture(input) {
    return this.gpu.device.createTexture({
      size: [input.width, input.height, 1],
      format: this.gpu.format,
      usage: GPUTextureUsage.TEXTURE_BINDING | GPUTextureUsage.RENDER_ATTACHMENT,
    })
  }

  // This is a no-op if input is null or if the input texture dimensions already matches the
  // existing intermediate texture dimensions.
  updateIntermediateTextures() {
    if (!this.input) {
      return
    }
    const { width, height } = this.input
    const current = this.intermediateTextures
    if (current[0]?.width === width && current[0]?.height === height) {
      return
    }
    current.forEach((texture) => texture.destroy())
    this.intermediateTextures = [
      this.createIntermediateTexture(this.input),
      this.createIntermediateTexture(this.input),
    ]
  }
}

// Wrapper for the current draw API and both versions of the earlier copy API.
// See https://github.com/WICG/html-in-canvas/issues/174.
function copyElementImageToInputTexture(content, runtime) {
  if (!runtime.input) {
    throw new Error('Cannot copy to null input texture')
  }
  const queue = runtime.gpu.device.queue

  if (queue.drawElementImageToTexture) {
    try {
      queue.drawElementImageToTexture(
        { source: content },
        { texture: runtime.input, size: { width: runtime.input.width, height: runtime.input.height } },
      )
      return
    } catch (error) {
      // Older HTML-in-Canvas implementations use copyElementImageToTexture.
      if (!queue.copyElementImageToTexture) {
        throw error
      }
    }
  }

  if (!queue.copyElementImageToTexture) {
    throw new Error('HTML-in-Canvas is not supported.')
  }
  try {
    queue.copyElementImageToTexture(
      { source: content },
      { destination: { texture: runtime.input }, width: runtime.input.width, height: runtime.input.height },
    )
  } catch {
    queue.copyElementImageToTexture(content, runtime.input.width, runtime.input.height, {
      texture: runtime.input,
    })
  }
}

function createInputTexture(device, format, canvas) {
  // RENDER_ATTACHMENT is mandatory on the destination of HTML-in-Canvas in Chrome's
  // implementation. Without it the call doesn't throw but silently writes nothing.
  return device.createTexture({
    size: [canvas.width, canvas.height, 1],
    format,
    usage: GPUTextureUsage.TEXTURE_BINDING | GPUTextureUsage.COPY_DST | GPUTextureUsage.RENDER_ATTACHMENT,
  })
}

// Fallback input path for browsers with WebGPU but without HTML-in-Canvas: when the effect's
// content is only images, rasterize them (object-fit: cover, opacity) into the input texture.
function imageLayers(host) {
  if (host.textContent.trim() !== '') {
    return null
  }
  const imgs = [...host.querySelectorAll('img')]
  if (imgs.length === 0) {
    return null
  }
  const hostRect = host.getBoundingClientRect()
  return imgs.map((img) => {
    const r = img.getBoundingClientRect()
    let opacity = 1
    for (let el = img; el && el !== host.parentElement; el = el.parentElement) {
      opacity *= parseFloat(getComputedStyle(el).opacity)
    }
    return {
      img,
      opacity,
      x: (r.left - hostRect.left) / hostRect.width,
      y: (r.top - hostRect.top) / hostRect.height,
      w: r.width / hostRect.width,
      h: r.height / hostRect.height,
    }
  })
}

function copyImageLayersToInputTexture(layers, runtime) {
  const { width, height } = runtime.input
  const scratch = new OffscreenCanvas(width, height)
  const ctx = scratch.getContext('2d')
  for (const layer of layers) {
    const dw = layer.w * width
    const dh = layer.h * height
    const { naturalWidth: iw, naturalHeight: ih } = layer.img
    const scale = Math.max(dw / iw, dh / ih)
    const sw = dw / scale
    const sh = dh / scale
    ctx.globalAlpha = layer.opacity
    ctx.drawImage(layer.img, (iw - sw) / 2, (ih - sh) / 2, sw, sh, layer.x * width, layer.y * height, dw, dh)
  }
  runtime.gpu.device.queue.copyExternalImageToTexture(
    { source: scratch },
    { texture: runtime.input, premultipliedAlpha: true },
    [width, height],
  )
}

/**
 * Applies a stack of shader effects to the children of `host`.
 *
 * `host` keeps its classes and children. When WebGPU is available it is swapped for a <canvas>
 * with the same classes that renders those children through the shaders: via HTML-in-Canvas
 * when supported, otherwise (image-only content) by uploading the images directly. Without
 * WebGPU, `host` is left untouched so the unshaded children stay visible exactly where the
 * design places them (the React runtime's `{children}` fallback).
 */
async function mountShaderEffect(host, shaders) {
  let device
  let layers = null
  try {
    device = await acquireDevice()
    const htmlInCanvas = 'drawElementImageToTexture' in device.queue || 'copyElementImageToTexture' in device.queue
    if (!htmlInCanvas) {
      const imgs = [...host.querySelectorAll('img')]
      await Promise.all(imgs.map((img) => img.decode()))
      layers = imageLayers(host)
      if (!layers) {
        throw new Error('HTML-in-Canvas is not supported.')
      }
      // WebGPU only accepts origin-clean sources (fails e.g. for images on file:// pages).
      const probe = new OffscreenCanvas(1, 1).getContext('2d')
      probe.drawImage(imgs[0], 0, 0, 1, 1)
      probe.getImageData(0, 0, 1, 1)
    }
  } catch (e) {
    console.warn('Shader effect disabled, showing unshaded content:', e.message)
    return null
  }
  const useHtmlInCanvas = layers === null

  const canvas = document.createElement('canvas')
  canvas.className = host.className
  canvas.style.display = 'block'
  const content = document.createElement('div')
  if (useHtmlInCanvas) {
    canvas.setAttribute('layoutsubtree', '')
    canvas.setAttribute('content', 'drawable')
    content.setAttribute('drawable', '')
    content.style.cssText = 'position:relative;width:100%;height:100%'
    content.append(...host.childNodes)
    canvas.append(content)
  } else {
    canvas.style.pointerEvents = 'none'
  }
  host.replaceWith(canvas)

  const restore = (e) => {
    console.warn('Failed to initialize shader runtime', e)
    host.append(...content.childNodes)
    canvas.replaceWith(host)
  }
  const requestPaint = () => {
    if (useHtmlInCanvas) {
      canvas.requestPaint()
    } else {
      requestAnimationFrame(() => renderCore())
    }
  }

  let runtime
  try {
    const context = canvas.getContext('webgpu')
    if (!context) {
      throw new Error('Failed to get WebGPU context.')
    }
    const format = 'rgba8unorm'
    context.configure({ device, format, alphaMode: 'premultiplied' })
    const rect = canvas.getBoundingClientRect()
    const renderScale = window.devicePixelRatio || 1
    canvas.width = Math.max(Math.round(rect.width * renderScale), 1)
    canvas.height = Math.max(Math.round(rect.height * renderScale), 1)
    runtime = new RuntimeState({ device, context, format }, createInputTexture(device, format, canvas))
  } catch (e) {
    restore(e)
    return null
  }

  let isDirtied = true
  let setupComplete = false
  let raf = null
  let lastTs = null

  const stopClock = () => {
    if (raf != null) {
      cancelAnimationFrame(raf)
      raf = null
    }
    lastTs = null
  }
  const startClock = () => {
    if (raf != null) {
      return
    }
    lastTs = null
    const tick = (ts) => {
      raf = requestAnimationFrame(tick)
      runtime._deltaTime = lastTs == null ? 0 : ts - lastTs
      lastTs = ts
      runtime._time += runtime._deltaTime
      runtime._frame += 1
      requestPaint()
    }
    raf = requestAnimationFrame(tick)
  }

  const renderCore = () => {
    // Skip until setup() has completed so render() never sees a half-initialized pipeline.
    if (!setupComplete || !runtime.input) {
      return
    }
    try {
      if (isDirtied) {
        if (useHtmlInCanvas) {
          copyElementImageToInputTexture(content, runtime)
        } else {
          copyImageLayersToInputTexture(layers, runtime)
        }
        isDirtied = false
      }
      runtime.updateIntermediateTextures()
      runtime.output = runtime.gpu.context.getCurrentTexture()
      shaders.forEach((effect, idx) => {
        effect.render(runtime.gpu.device, runtime.getShaderState(idx))
      })    } catch (e) {
      // Render-path failures are treated as transient (e.g. no paint record yet on the very
      // first paint); the next paint typically succeeds.
      console.warn('Failed to render effect', e)
      return
    }
    if (runtime.isAnimated) {
      startClock()
    } else {
      stopClock()
    }
  }

  // Effect-specific setup.
  runtime.isAnimated = shaders.some((effect) => (effect.manifest ?? DEFAULT_MANIFEST).isAnimated)
  runtime.usesMouse = shaders.some((effect) => (effect.manifest ?? DEFAULT_MANIFEST).usesMouse)
  runtime.shaderData = shaders.map((effect) => ({ shader: effect, state: {} }))
  try {
    runtime.updateIntermediateTextures()
    shaders.forEach((effect, idx) => {
      effect.setup(runtime.gpu.device, runtime.getShaderState(idx))
    })
    setupComplete = true
  } catch (e) {
    restore(e)
    return null
  }

  if (useHtmlInCanvas) {
    canvas.onpaint = (event) => {
      if (event.changedElements.length > 0) {
        isDirtied = true
      }
      renderCore()
    }
  }

  // Track device-pixel size so the canvas grid stays crisp.
  new ResizeObserver((entries) => {
    const renderScale = window.devicePixelRatio || 1
    for (const entry of entries) {
      const size = entry.contentBoxSize?.[0]
      canvas.width = Math.max(Math.round((size?.inlineSize ?? entry.contentRect.width) * renderScale), 1)
      canvas.height = Math.max(Math.round((size?.blockSize ?? entry.contentRect.height) * renderScale), 1)
    }
    runtime.input?.destroy()
    runtime.input = createInputTexture(runtime.gpu.device, runtime.gpu.format, canvas)
    isDirtied = true
    runtime.updateIntermediateTextures()
    requestPaint()
  }).observe(canvas, { box: 'device-pixel-content-box' })

  if (runtime.usesMouse) {
    const mouseSync = (e) => {
      const rect = canvas.getBoundingClientRect()
      if (rect.width === 0 || rect.height === 0) {
        return
      }
      runtime._mousePosition.x = ((e.clientX - rect.left) * canvas.width) / rect.width
      runtime._mousePosition.y = ((e.clientY - rect.top) * canvas.height) / rect.height
    }
    // The rAF clock already repaints animated effects, so only repaint when it isn't running.
    const repaint = () => {
      if (raf == null) {
        requestPaint()
      }
    }
    window.addEventListener('pointermove', (e) => { mouseSync(e); repaint() }, { passive: true })
    window.addEventListener('pointerdown', (e) => {
      if (e.button !== 0) return
      runtime._mousePosition.down = true
      mouseSync(e)
      repaint()
    }, { passive: true })
    const clearDown = () => {
      if (!runtime._mousePosition.down) return
      runtime._mousePosition.down = false
      repaint()
    }
    window.addEventListener('pointerup', (e) => { if (e.button === 0) clearDown() }, { passive: true })
    window.addEventListener('pointercancel', clearDown, { passive: true })
  }

  requestPaint()
  return canvas
}

window.ShaderRuntime = Object.assign(window.ShaderRuntime || {}, { mountShaderEffect, DEFAULT_MANIFEST })
})()
