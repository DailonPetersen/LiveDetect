const apiKey = "f4393d4b42804052aa3915ffb0026b24"
const apiUrl = "https://dailonpetersenftec.cognitiveservices.azure.com/face/v1.0/"

$('#groupName').change( e => {
    var final = $('#groupName').val()
    const group_id = generateRamdomString() +'_'+final
    criaInputHidden(group_id)

})

const generateRamdomString = () =>{
    return Math.random().toString(36).substr(2, 6)
}

function criaInputHidden(final) {
    if ( $('#groupId').val() != '' ){
        alert('O ID DO GRUPO NAO SERÁ mudado')
    } else {
        $('#groupId').attr("value", final )
    }
}

function salvarGrupo(valorBotao) {

    console.log(valorBotao)

    var GroupName = $('#groupName').val()
    var GroupData = $('#groupData').val()
    var NameFinal = $('#groupId').val()

    if ( valorBotao == 'Cadastrar' ){
        createGroup(GroupName, GroupData, NameFinal)
    } else if ( valorBotao == 'Atualizar') {
        updateGroup(GroupName, GroupData, NameFinal)
    }

}

function updateGroup(GroupName, GroupData, NameFinal) {
    
    var data = {
        "name": `${GroupName}`,
        "userData": `${GroupData}`,
    }

    $.ajax({
        url: apiUrl + `persongroups/${NameFinal}`,
        type: 'PATCH',
        beforeSend: xhrObj =>{
            xhrObj.setRequestHeader("Content-Type","application/json")
            xhrObj.setRequestHeader("Ocp-Apim-Subscription-Key",apiKey)
        },
        data: JSON.stringify(data),
    })
    .done( success => {
        alert('Foi')
    })
    .fail( error => {
        alert(error)
        console.log(error)
    })

    createGroupDB(GroupName, GroupData, NameFinal)

}

function createGroupDB(GroupName, GroupData, NameFinal){

    const data = {
        "groupName": GroupName,
        "groupData": GroupData,
        "groupId": NameFinal,
    }

    $.ajax({
        url:'cad_grupo.php',
        type: 'POST',
        data: data,
        async: true
    })
    .done( success => {
        console.log('salvou')
    })
    .fail( error => {
        console.log('nao salvou')
    })
}

function createGroup(GroupName, GroupData, NameFinal) {
    
    var data = {
        "name": `${GroupName}`,
        "userData": `${GroupData}`,
        "recognitionModel":"recognition_02"
    }

    $.ajax({
        url: apiUrl + `persongroups/${NameFinal}`,
        type: 'PUT',
        beforeSend: xhrObj =>{
            xhrObj.setRequestHeader("Content-Type","application/json")
            xhrObj.setRequestHeader("Ocp-Apim-Subscription-Key",apiKey)
        },
        data: JSON.stringify(data),
    })
    .done( success => {
        alert('Foi')
    })
    .fail( error => {
        alert(error)
        console.log(error)
    })
    
    createGroupDB(GroupName, GroupData, NameFinal)
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