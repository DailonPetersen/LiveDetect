const video = document.getElementById('video')

Promise.all([
    faceapi.nets.tinyFaceDetector.loadFromUri('./models'),
    faceapi.nets.faceLandmark68Net.loadFromUri('./models'),
    faceapi.nets.faceRecognitionNet.loadFromUri('./models'),
    faceapi.nets.faceExpressionNet.loadFromUri('./models')
]).then(startVideo())

function startVideo() {
    navigator.getUserMedia(
        { video : {} },
        stream => video.srcObject = stream,
        error => console.error(error)
    )
    console.log('rodando')
}

video.addEventListener('play', () => {

    const canvas = faceapi.createCanvasFromMedia(video)
    document.body.append(canvas)
    const displaySize = { width: video.width, height:video.height }
    faceapi.matchDimensions(canvas, displaySize)

    setInterval( async () => {

        const detection = await faceapi.detectAllFaces(video, new faceapi.TinyFaceDetectorOptions()).withFaceLandmarks().withFaceExpressions().withFaceDescriptors()
        const DeteccoesAjustadas = faceapi.resizeResults(detection, displaySize)
        console.log(detection[0]["expressions"])

        //CaptureImage();

        canvas.getContext('2d').clearRect(0, 0, canvas.width, canvas.height)

        faceapi.draw.drawDetections(canvas, DeteccoesAjustadas)
        faceapi.draw.drawFaceLandmarks(canvas, DeteccoesAjustadas)
        faceapi.draw.drawFaceExpressions(canvas, DeteccoesAjustadas)

    },500)
})