// Port of Figma's shader runtime `webgpu.ts` (React hook removed, logic unchanged).
// Classic script (not an ES module) so the page also works when opened from file://.
(() => {

// Module-level singleton. Acquiring a GPUDevice is expensive and a single device can
// back every ShaderEffect on the page, so we acquire it once and hand the same promise
// to all callers rather than one device per component.
let devicePromise = null

// Requests the adapter and device on first call and caches the promise. On failure the
// cache is cleared so a later mount can retry.
function acquireDevice() {
  if (!devicePromise) {
    devicePromise = (async () => {
      const gpu = navigator.gpu
      if (!gpu) {
        throw new Error('WebGPU unsupported.')
      }
      const adapter = await gpu.requestAdapter()
      if (!adapter) {
        throw new Error('Failed to get WebGPU adapter.')
      }
      return adapter.requestDevice()
    })()
    devicePromise.catch(() => {
      devicePromise = null
    })
  }
  return devicePromise
}

window.ShaderRuntime = Object.assign(window.ShaderRuntime || {}, { acquireDevice })
})()
