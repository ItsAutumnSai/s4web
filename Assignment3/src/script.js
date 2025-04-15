import './style.css'
import { Clock, Scene, LoadingManager, WebGLRenderer, sRGBEncoding, Group, PerspectiveCamera, DirectionalLight, PointLight, MeshPhongMaterial, TextureLoader, RepeatWrapping, SRGBColorSpace } from 'three';
import { TWEEN } from 'three/examples/jsm/libs/tween.module.min.js'
import { DRACOLoader } from 'three/examples/jsm/loaders/DRACOLoader.js'
import { GLTFLoader } from 'three/examples/jsm/loaders/GLTFLoader.js'

const ftsLoader = document.querySelector(".lds-roller")
const looadingCover = document.getElementById("loading-text-intro")
const loadingManager = new LoadingManager()

loadingManager.onLoad = function () {

    document.querySelector(".main-container").style.visibility = 'visible'
    document.querySelector("body").style.overflow = 'auto'

    const yPosition = { y: 0 }

    new TWEEN.Tween(yPosition).to({ y: 100 }, 900).easing(TWEEN.Easing.Quadratic.InOut).start()
        .onUpdate(function () { looadingCover.style.setProperty('transform', `translate( 0, ${yPosition.y}%)`) })
        .onComplete(function () { looadingCover.parentNode.removeChild(document.getElementById("loading-text-intro")); TWEEN.remove(this) })

    introAnimation()
    ftsLoader.parentNode.removeChild(ftsLoader)

    window.scroll(0, 0)

}

/////////////////////////////////////////////////////////////////////////
//// DRACO LOADER TO LOAD DRACO COMPRESSED MODELS FROM BLENDER
const dracoLoader = new DRACOLoader()
dracoLoader.setDecoderPath('/draco/')
dracoLoader.setDecoderConfig({ type: 'js' })
const loader = new GLTFLoader(loadingManager)
loader.setDRACOLoader(dracoLoader)

/////////////////////////////////////////////////////////////////////////
///// DIV CONTAINER CREATION TO HOLD THREEJS EXPERIENCE
const container = document.getElementById('canvas-container')
const containerDetails = document.getElementById('canvas-container-details')

/////////////////////////////////////////////////////////////////////////
///// GENERAL VARIABLES
let oldMaterial
let secondContainer = false
let width = container.clientWidth
let height = container.clientHeight

/////////////////////////////////////////////////////////////////////////
///// SCENE CREATION
const scene = new Scene()

/////////////////////////////////////////////////////////////////////////
///// RENDERER CONFIG
const renderer = new WebGLRenderer({ antialias: true, alpha: true, powerPreference: "high-performance" })
renderer.autoClear = true
renderer.setPixelRatio(Math.min(window.devicePixelRatio, 1))
renderer.setSize(width, height)
renderer.outputEncoding = sRGBEncoding
container.appendChild(renderer.domElement)

const renderer2 = new WebGLRenderer({ antialias: false })
renderer2.setPixelRatio(Math.min(window.devicePixelRatio, 1))
renderer2.setSize(width, height)
renderer2.outputEncoding = sRGBEncoding
containerDetails.appendChild(renderer2.domElement)

/////////////////////////////////////////////////////////////////////////
///// CAMERAS CONFIG
const cameraGroup = new Group()
scene.add(cameraGroup)

const camera = new PerspectiveCamera(35, width / height, 1, 100)
camera.position.set(19, 1.54, -0.1)
cameraGroup.add(camera)

const camera2 = new PerspectiveCamera(35, containerDetails.clientWidth / containerDetails.clientHeight, 1, 100)
camera2.position.set(1.9, 3.5, 2.7)
camera2.rotation.set(0, 1.1, 0)
scene.add(camera2)

/////////////////////////////////////////////////////////////////////////
///// MAKE EXPERIENCE FULL SCREEN
window.addEventListener('resize', () => {
    camera.aspect = container.clientWidth / container.clientHeight
    camera.updateProjectionMatrix()

    camera2.aspect = containerDetails.clientWidth / containerDetails.clientHeight
    camera2.updateProjectionMatrix()

    renderer.setSize(container.clientWidth, container.clientHeight)
    renderer2.setSize(containerDetails.clientWidth, containerDetails.clientHeight)

    renderer.setPixelRatio(Math.min(window.devicePixelRatio, 1))
    renderer2.setPixelRatio(Math.min(window.devicePixelRatio, 1))
})

const sunLight = new DirectionalLight(0x435c72, 0.08)
sunLight.position.set(-100, 0, -100)
scene.add(sunLight)

const fillLight = new PointLight(0xfdf35e, 10, 4, 3)
fillLight.position.set(30, 3, 1.8)
scene.add(fillLight)

const textureModel = new TextureLoader().load('textures/BakedsultanagunG.png');
textureModel.wrapS = RepeatWrapping;
textureModel.wrapT = RepeatWrapping;
textureModel.flipY = false;
// textureModel.colorSpace = SRGBColorSpace;
textureModel.channel = 0;
loader.load('models/gltf/model.glb', function (gltf) {

    gltf.scene.traverse((obj) => {
        if (obj.isMesh) {
            oldMaterial = obj.material
            obj.material = new MeshPhongMaterial({
                map:textureModel,
                shininess: 0
            })
        }
    })
    scene.add(gltf.scene)
    clearScene()
})

function clearScene() {
    oldMaterial.dispose()
    renderer.renderLists.dispose()
}

/////////////////////////////////////////////////////////////////////////
//// INTRO CAMERA ANIMATION USING TWEEN
function introAnimation() {
    new TWEEN.Tween(camera.position.set(0, 4, 2.7)).to({ x: 0, y: 3, z: 8.8 }, 3500).easing(TWEEN.Easing.Quadratic.InOut).start()
        .onComplete(function () {
            TWEEN.remove(this)
            document.querySelector('.header').classList.add('ended')
            document.querySelector('.first>p').classList.add('ended')
        })

}

//////////////////////////////////////////////////
//// CLICK LISTENERS
document.getElementById('agung').addEventListener('click', () => {
    document.getElementById('agung').classList.add('active')
    document.getElementById('sultan').classList.remove('active')
    document.getElementById('content').innerHTML = 'Halo! Saya Agung.'
    animateCamera({ x: 1.9, y: 3.5, z: 2.7 }, { y: 1.1 })
})

document.getElementById('sultan').addEventListener('click', () => {
    document.getElementById('sultan').classList.add('active')
    document.getElementById('agung').classList.remove('active')
    document.getElementById('content').innerHTML = 'Halo! Saya Sultan.'
    animateCamera({ x: -0, y: 3.6, z: 2.6 }, { y: -0.1 })
})

/////////////////////////////////////////////////////////////////////////
//// ANIMATE CAMERA
function animateCamera(position, rotation) {
    new TWEEN.Tween(camera2.position).to(position, 1800).easing(TWEEN.Easing.Quadratic.InOut).start()
        .onComplete(function () {
            TWEEN.remove(this)
        })
    new TWEEN.Tween(camera2.rotation).to(rotation, 1800).easing(TWEEN.Easing.Quadratic.InOut).start()
        .onComplete(function () {
            TWEEN.remove(this)
        })
}

/////////////////////////////////////////////////////////////////////////
//// PARALLAX CONFIG
const cursor = { x: 0, y: 0 }
const clock = new Clock()
let previousTime = 0

/////////////////////////////////////////////////////////////////////////
//// RENDER LOOP FUNCTION

function rendeLoop() {

    TWEEN.update()

    if (secondContainer) {
        renderer2.render(scene, camera2)
    } else {
        renderer.render(scene, camera)
    }

    const elapsedTime = clock.getElapsedTime()
    const deltaTime = elapsedTime - previousTime
    previousTime = elapsedTime

    const parallaxY = cursor.y
    fillLight.position.y -= (parallaxY * 9 + fillLight.position.y - 2) * deltaTime

    const parallaxX = cursor.x
    fillLight.position.x += (parallaxX * 8 - fillLight.position.x) * 2 * deltaTime

    cameraGroup.position.z -= (parallaxY / 3 + cameraGroup.position.z) * 2 * deltaTime
    cameraGroup.position.x += (parallaxX / 3 - cameraGroup.position.x) * 2 * deltaTime

    requestAnimationFrame(rendeLoop)
}

rendeLoop()

//////////////////////////////////////////////////
//// ON MOUSE MOVE TO GET CAMERA POSITION
document.addEventListener('mousemove', (event) => {
    event.preventDefault()

    cursor.x = event.clientX / window.innerWidth - 0.5
    cursor.y = event.clientY / window.innerHeight - 0.5

    handleCursor(event)
}, false)

//////////////////////////////////////////////////
//// DISABLE RENDERER BASED ON CONTAINER VIEW
const watchedSection = document.querySelector('.second')

function obCallback(payload) {
    if (payload[0].intersectionRatio > 0.05) {
        secondContainer = true
    } else {
        secondContainer = false
    }
}

const ob = new IntersectionObserver(obCallback, {
    threshold: 0.05
})

ob.observe(watchedSection)

//////////////////////////////////////////////////
//// MAGNETIC MENU
const btn = document.querySelectorAll('nav > .a')
const customCursor = document.querySelector('.cursor')

function update(e) {
    const span = this.querySelector('span')

    if (e.type === 'mouseleave') {
        span.style.cssText = ''
    } else {
        const { offsetX: x, offsetY: y } = e, { offsetWidth: width, offsetHeight: height } = this,
            walk = 20, xWalk = (x / width) * (walk * 2) - walk, yWalk = (y / height) * (walk * 2) - walk
        span.style.cssText = `transform: translate(${xWalk}px, ${yWalk}px);`
    }
}

const handleCursor = (e) => {
    const x = e.clientX
    const y = e.clientY
    customCursor.style.cssText = `left: ${x}px; top: ${y}px;`
}

btn.forEach(b => b.addEventListener('mousemove', update))
btn.forEach(b => b.addEventListener('mouseleave', update))