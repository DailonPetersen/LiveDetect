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

    if( intervalo == null ) {
        intervalo = 60000
        console.log('intervalo '+intervalo)
    } else {
        var intervalo = $('#intervalo').val()
        intervalo = intervalo*60000
        console.log('intervalo '+intervalo)
    }

    const canvas = faceapi.createCanvasFromMedia(video)
    $('.form-panel').append(canvas)
    const displaySize = { width: video.width, height:video.height }

    faceapi.matchDimensions(canvas, displaySize)

    setInterval( async () => {
        const deteccoes = await faceapi.detectAllFaces(video, new faceapi.TinyFaceDetectorOptions()).withFaceLandmarks().withFaceExpressions().withFaceDescriptors()
        const DeteccoesAjustadas = faceapi.resizeResults(deteccoes, displaySize)

        canvas.getContext('2d').clearRect(0, 0, canvas.width, canvas.height)
        faceapi.draw.drawDetections(canvas, DeteccoesAjustadas)
        faceapi.draw.drawFaceLandmarks(canvas, DeteccoesAjustadas)
        faceapi.draw.drawFaceExpressions(canvas, DeteccoesAjustadas)

        canvas.getContext('2d').drawImage(video, 0, 0, video.videoWidth, video.videoHeight)
        canvas.toBlob( blob => {
            console.log(blob)
            Detect( blob )
        }, 'image/jpeg', 0.95)
        canvas.getContext('2d').clearRect(0, 0, canvas.width, canvas.height)

    }, intervalo)

    $('#detecta').click( () => {

        canvas.getContext('2d').drawImage(video, 0, 0, video.videoWidth, video.videoHeight)
        canvas.toBlob( blob => {
            console.log(blob)
            Detect( blob )
        }, 'image/jpeg', 0.95)
        canvas.getContext('2d').clearRect(0, 0, canvas.width, canvas.height)
    })
    
})


function Detect(file){
    if(file == null) {
        file = document.getElementById('img').files[0]
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
            $('#detectresponse').text(JSON.stringify(response));
            var result = Array.from(response)
            console.log(response)
            function logArrayElements(element, index, array) {
                //var faceId = JSON.stringify(element['faceId'])
                //var emotions = JSON.stringify(element['faceAttributes']['emotion'])
                //console.log("a[" + index + "] = " + JSON.stringify(element['faceId']));

                var faceId = element.faceId
                var emotions = element.faceAttributes.emotion
                Identify(faceId,null, emotions) 
            }
            result.forEach(logArrayElements)
            
        })
        .fail( (error) =>{
            $("#detectresponse").text(error)
        })
}

async function Identify(faceId, group_id, emotions){

    console.log(faceId)

    group_id = $('#grupoAdetectar').val()
    console.log(group_id)
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
        console.log(response[0]['candidates'][0]['personId'])
        $('#detectresponse').text(JSON.stringify(response[0]['candidates'][0]['personId']))
    })
    .fail( error =>{
        console.error(error)
    })
    .then( response => {
        GetPerson(response[0]['candidates'][0]['personId'], group_id, emotions)
    })
    
}

async function GetPerson(personId, group_id, emotions){

    await $.ajax({
        url: apiUrl + `persongroups/${group_id}/persons/${personId}`,
        type: 'GET',
        beforeSend: xhrObj => {
            xhrObj.setRequestHeader('Ocp-Apim-Subscription-Key',apiKey)
        }
    })
    .done( (response) => {
        let nome = response['name']
        let personId = response['personId']
        alert('Este é o '+nome)
        var valorAtual = $('#detectresponse').val();
        $('#detectresponse').text(valorAtual +  '\n Este é o '+nome);
        salvaEmocaoDB(emotions, personId, group_id)
    })
    .fail( (error) =>{
        console.error(error)
    })
}

function salvaEmocaoDB(emotions, personId, group_id){
    
    const data = {
        "emocoes": emotions,
        "person_id": personId,
        "group_id": group_id
    }
    console.log(data)
    console.log(JSON.stringify(data))

    $.ajax({
        url: 'livedetect.php',
        type: 'POST',
        data: data,
        async: true
    })
    .done( (response) => {
        console.log('Salvou Emocao')
    })
    .fail( (error) =>{
        console.error(error)
    })

}


