
const img = document.getElementById('inputImage')
const apiKey = "f4393d4b42804052aa3915ffb0026b24"
const apiUrl = "https://dailonpetersenftec.cognitiveservices.azure.com/face/v1.0/"


function scarrega() {
    var xhr = new XMLHttpRequest()
    
    xhr.open('GET', 'http://127.0.0.1:5500/imagens/1.JPEG')
    xhr.responseType = 'arraybuffer'

    xhr.onload = e => {
        var blob = new Blob([xhr.response])
        var url = URL.createObjectURL(blob)

        console.log(url)
        var img = document.getElementById('img')
        img.src = url
    }

    xhr.send()
}

const generateRamdomString = () =>{
    return Math.random().toString(36).substr(2, 6)
}

function createGroup(GroupName, GroupData) {
    //const GroupName = $('#groupName').val()
    //const GroupData = $('#groupData').val()
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
        alert(JSON.stringify(success))
        console.log(success)
    })
    .fail( error => {
        alert(error)
        console.log(error)
    })
}

function createPerson(PersonName, PersonData, group_id) {

    group_id = document.getElementById('groupId').value
    PersonName = document.getElementById('personName').value
    PersonData = document.getElementById('personData').value

    var xhr = new XMLHttpRequest()

    xhr.open('POST', apiUrl+`persongroups/${group_id}/persons`)
    
    var body = {
        "name" : `${PersonName}`,
        "userData": `${PersonData}`
    }
    xhr.setRequestHeader("Content-Type","application/json")
    xhr.setRequestHeader("Ocp-Apim-Subscription-Key", apiKey)

    xhr.onreadystatechange = () => {
        if ( this.readyState === XMLHttpRequest.DONE){
            alerta('Criado')
        }
    }

    xhr.send(JSON.stringify(body))

}

$('#salva_imagens').submit( e => {
    e.preventDefault()

    var formulario = $(this)
    var retorno = salvaImagem(formulario)
})

function salvaImagem(formulario) {

    $.ajax({
        type:'POST',
        data: formulario.serialize(),
        url:'salvar.php',
        async: true
    })
    .done(function (response) {
        console.log(response)
    })
    .fail(function (error) {
        console.error(error)
    });

}

//async function AddFaceToPersonGroup(file, personId, groupId) {
//
//    personId = $('#personId').val()
//    groupId = $('#groupId').val()
//
//
//    for ( let i = 0; i<=1; i++) {
//
//        file = document.getElementById('inputFiles').files[i]
//        console.log(file)
//
//        await $.ajax({
//            url: apiUrl + `persongroups/${groupId}/persons/${personId}/persistedFaces`,
//            beforeSend: function (xhrObj) {
//                xhrObj.setRequestHeader("Content-Type", "application/octet-stream");
//                xhrObj.setRequestHeader("Ocp-Apim-Subscription-Key", apiKey);
//            },
//            type: "POST",
//            data: file,
//            processData: false
//        })
//            .done(function (response) {
//                console.log(response)
//            })
//            .fail(function (error) {
//                console.error(error)
//            });        
//    }
//}


function Identify(data, apiKey){
    $.ajax({
        url: 'https://dailonpetersenftec.cognitiveservices.azure.com/face/v1.0/identify',
        type: 'POST',
        beforeSend: function(xhrObj){
            xhrObj.setRequestHeader("Content-Type","application/json")
            xhrObj.setRequestHeader("Ocp-Apim-Subscription-Key", apiKey)
        },
        data: {
            "personGroupId": "pg_123",
            "faceIds": `${data}`,
            "maxNumOfCandidatesReturned": 1,
            "confidenceThreshold": 0.5
        },
    })
    .done( response => {
        console.log(response)
    })
    .fail( error =>{
        console.error(error)
    })

}