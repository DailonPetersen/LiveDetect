
const img = document.getElementById('inputImage')
const apiKey = "f4393d4b42804052aa3915ffb0026b24"
const apiUrl = "https://dailonpetersenftec.cognitiveservices.azure.com/face/v1.0/"
const video = document.getElementById('video') // from videolive.html
const canvas = document.getElementById('canvas') // from videolive.html

async function carrega() {
    await $.ajax({
        url: 'carregaImages.php',
        type: 'POST',
        async: true
    })
    .done(function (response) {
        console.log(response)
    })
    .fail(function (error) {
        console.error(error)
    });

}

const generateRamdomString = () =>{
    return Math.random().toString(36).substr(2, 6)
}

function createGroup(GroupName, GroupData) {

    GroupName = $('#groupName').val()
    GroupData = $('#groupData').val()

    const group_id = generateRamdomString() +'_'+ GroupName
    var final = group_id.toLowerCase()

    var data = {
        "name": `${GroupName}`,
        "recognitionModel":"recognition_02"
    }

    $.ajax({
        url: apiUrl + `persongroups/${final}`,
        type: 'PUT',
        beforeSend: xhrObj =>{
            xhrObj.setRequestHeader("Content-Type","application/json")
            xhrObj.setRequestHeader("Ocp-Apim-Subscription-Key",apiKey)
        },
        data: JSON.stringify(data),
    })
    .done( success => {
        alert("Grupo criado! id: "+final)
        
    })
    .fail( error => {
        alert(error)
        console.log(error)
    })
}

function createPerson(PersonName, PersonData, group_id) {

    group_id = $('#groupId').val()
    PersonName = $('#personName').val()
    PersonData = $('#personData').val()

    var data = {
        "name" : `${PersonName}`,
        "userData": `${PersonData}`
    }

    $.ajax({
        url: apiUrl + `persongroups/${group_id}/persons`,
        type: "POST",
        beforeSend(xhr){
            xhr.setRequestHeader("Content-Type","application/json")
            xhr.setRequestHeader("Ocp-Apim-Subscription-Key", apiKey)
        },
        data: JSON.stringify(data)
    })
    .done(function (response) {
        alert("Pessoa criada com sucesso! ID: "+response["personId"])
        
        document.getElementById('personId').value = (response["personId"])
    })
    .fail(function (error) {
        console.error(error)
    });

    $('#groupIdImage').val(group_id)

}

$('#salva_imagens').submit( e => {
    //e.preventDefault()
    AddFaceToPersonGroup(null, null, null, null)
})

async function AddFaceToPersonGroup(file, personId, groupId) {

    personId = $('#personId').val()
    groupId = $('#groupIdImage').val()

    var length = document.getElementById('inputFiles').files.length
    console.log(length)
    for ( let i = 0; i<length; i++) {

        file = document.getElementById('inputFiles').files[i]
        console.log(file)
        await $.ajax({
            url: apiUrl + `persongroups/${groupId}/persons/${personId}/persistedFaces`,
            beforeSend: function (xhrObj) {
                xhrObj.setRequestHeader("Content-Type", "application/octet-stream");
                xhrObj.setRequestHeader("Ocp-Apim-Subscription-Key", apiKey);
            },
            type: "POST",
            data: file,
            processData: false
        })
            .done(function (response) {
                console.log(response)
                alert("Imagem adicionada com sucesso!")
            })
            .fail(function (error) {
                console.error(error)
            });        
    }
}

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
            let data = JSON.stringify(response, null, 2)
            $("#detectResponse").text(data)
            Identify(response[0]["faceId"],null) 
        })
        .fail( (error) =>{
            $("#detectResponse").text(error)
        })
}

async function Identify(faceId, group_id){

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
        GetPerson(response[0]['candidates'][0]['personId'], null)
    })

}

async function GetPerson(faceId, group_id){

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
        alert('Este é o '+nome)
    })
    .fail( (error) =>{
        console.error(error)
    })
}

// *********************** live video ********************* //

Promise.all([
    faceapi.nets.tinyFaceDetector.loadFromUri('./models'),
    faceapi.nets.faceLandmark68Net.loadFromUri('./models'),
    faceapi.nets.faceRecognitionNet.loadFromUri('./models'),
    faceapi.nets.faceExpressionNet.loadFromUri('./models'),
]).then(startVideo())


async function startVideo() {
    navigator.getUserMedia(
        { video : {} },
        stream => video.srcObject = stream,
        error => console.error(error)
    )
    console.log('rodando')
}

function CaptureImage(){
    canvas.width = video.width
    canvas.height = video.videoHeight;
    var file =  canvas.getContext('2d').drawImage(video, 0, 0, video.videoWidth, video.videoHeight);  
    //var data = canvas.toDataUrl('image/jpeg', 1.0)
    canvas.toBlob( blob => {
        Detect(blob, null)
    }, 'image/jpeg', 0.95)
}

video.addEventListener('play', () => {
    setInterval( async () => {
        const detection = await faceapi.detectAllFaces(video, new faceapi.TinyFaceDetectorOptions()).withFaceLandmarks().withFaceExpressions()
        console.log(detection[0]["expressions"])
        //CaptureImage();
    },2000)
})




