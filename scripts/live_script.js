const apiKey = "f4393d4b42804052aa3915ffb0026b24"
const apiUrl = "https://dailonpetersenftec.cognitiveservices.azure.com/face/v1.0/"
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

        canvas.getContext('2d').clearRect(0, 0, canvas.width, canvas.height)
        canvas.getContext('2d').drawImage(video, 0, 0, video.videoWidth, video.videoHeight)
        faceapi.draw.drawDetections(canvas, DeteccoesAjustadas)
        faceapi.draw.drawFaceExpressions(canvas, DeteccoesAjustadas)

        canvas.toBlob( Blob => {
            Detect( Blob, null)
        }, 'image/jpeg', 0.95)

    },1000)
})

//function CaptureImage(){
//
//    const canvas = document.getElementsByTagName('canvas')
//    canvas.width = video.videoWidth
//    canvas.height = video.videoHeight
//    var file =  canvas.getContext('2d').drawImage(video, 0, 0, video.videoWidth, video.videoHeight) 
//    //var data = canvas.toDataUrl('image/jpeg', 1.0)
//    canvas.toBlob( blob => {
//        Detect(blob, null)
//    }, 'image/jpeg', 0.95)
//}


function Detect(file, params){
    if(file == null) {
        file = document.getElementById('inputToDetect').files[0]
    }

    var params = {
        "returnFaceId": "true",
        "returnFaceLandmarks": "false",
        "recognitionModel":"recognition_02",
        "returnFaceAttributes":
            "age,emotion"
    }

    $.ajax({
        url: apiUrl + "detect?" + $.param(params),
        type: 'POST',
        beforeSend: function(xhrObj){
            xhrObj.setRequestHeader("Content-Type","application/octet-stream")
            xhrObj.setRequestHeader("Ocp-Apim-Subscription-Key", apiKey)
        },
        data: file,
        processData: false,
    })
        .done( (response) => {
            console.log(response)
            var emotions = response[0]['faceAttributes']['emotion']
            Identify(response[0]["faceId"],null, emotions) 
        })
        .fail( (error) =>{
            $("#detectResponse").text(error)
        })
}

async function Identify(faceId, group_id, emotions){

    console.log(faceId)

    group_id = "group_1"

    var data = {
        "personGroupId": `${group_id}`,
        "faceIds": [`${faceId}`],
        "maxNumOfCandidatesReturned": 1,
        "confidenceThreshold": 0.5
    }


    $.ajax({
        url: apiUrl + 'identify',
        type: 'POST',
        beforeSend: function(xhrObj){
            xhrObj.setRequestHeader("Content-Type","application/json")
            xhrObj.setRequestHeader("Ocp-Apim-Subscription-Key", apiKey)
        },
        data: JSON.stringify(data),
    })
    .done( response => {
        alert("Identificou!")
        console.log(response[0]['candidates'][0]['personId'])
    })
    .fail( error =>{
        console.error(error)
    })
    .then( response => {
        GetPerson(response[0]['candidates'][0]['personId'], null, emotions)
    })

}

async function GetPerson(faceId, group_id, emotions){

    group_id = 'group_1'

    await $.ajax({
        url: apiUrl + `persongroups/${group_id}/persons/${faceId}`,
        type: 'GET',
        beforeSend: xhrObj => {
            xhrObj.setRequestHeader('Ocp-Apim-Subscription-Key',apiKey)
        }
    })
    .done( (response) => {
        let nome = response['name']
        let personId = response['personId']
        alert('Este é o '+nome)
        salvaEmocaoDB(faceId, emotions, personId)
    })
    .fail( (error) =>{
        console.error(error)
    })
}

function salvaEmocaoDB(faceId, emotions, personId){
    
    const data = {
        "faceId": faceId,
        "emocoes": emotions,
        "id_pessoa": personId
    }
    console.log(JSON.stringify(data))

    $.ajax({
        url: 'livedetect.php',
        type: 'POST',
        data: data,
        async: true
    })
    .done( (response) => {
        alert('Salvou emocao')
    })
    .fail( (error) =>{
        console.error(error)
    })

}


