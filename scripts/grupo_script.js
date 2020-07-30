const apiKey = "f4393d4b42804052aa3915ffb0026b24"
const apiUrl = "https://dailonpetersenftec.cognitiveservices.azure.com/face/v1.0/"

$('#groupName').change( e => {
    var final = $('#groupName').val()
    const group_id = generateRamdomString() +'_'+final
    criaInputHidden(group_id.toLowerCase())

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
        var url_string = window.location.href;
        var url = new URL(url_string);
        var group_id = url.searchParams.get('update_id');
        console.log(GroupName, GroupData, group_id)
        updateGroup(GroupName, GroupData, group_id)
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
        createGroupDB(GroupName, GroupData, NameFinal)
    })
    .fail( error => {
        alert(error)
        console.log(error)
    })

}

function createGroupDB(GroupName, GroupData, NameFinal){

    const data = {
        "groupName": GroupName,
        "groupData": GroupData,
        "groupId": NameFinal,
    }
    console.log(JSON.stringify(data));

    $.ajax({
        url:'cad_grupo.php',
        type: 'POST',
        data: data,
        async: false
    })
    .done( success => {
        console.log('Sucesso!')
        window.location.href = "http://localhost/livedetect2/index.php?p=cad_grupo"
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
        alert('Grupo cadastrado com sucesso!')
    })
    .fail( error => {
        alert(error)
        console.log(error)
    })
    
    createGroupDB(GroupName, GroupData, NameFinal)
}

function deleta(group_id){

    alert(group_id)
    console.log(group_id);
    //$.ajax({
    //    url: apiUrl + `persongroups/${group_id}`,
    //    type: 'DELETE',
    //    beforeSend: xhrObj =>{
    //        xhrObj.setRequestHeader("Ocp-Apim-Subscription-Key",apiKey)
    //    }
    //})
    //.done( success => {
    //    alert('Grupo Deletado com sucesso!')
    //    deletaDB(group_id)
    //    window.location.href = "http://localhost/livedetect2/index.php?p=cad_grupo"
    //})
    //.fail( error => {
    //    alert(error)
    //    console.log(error)
    //})
}

function deletaDB(group_id){
    
    const data = {
        "groupId": group_id,
    }

    $.ajax({
        url:'cad_grupo.php',
        type: 'GET',
        data: data,
        async: true
    })
    .done( success => {
        console.log('Grupo Deletado com sucesso!')
    })
    .fail( error => {
        console.log('nao salvou')
    })
}

function treinarGrupo(group_id){
    $.ajax({
        url: apiUrl + `persongroups/${group_id}/train`,
        type: 'POST',
        beforeSend: xhrObj =>{
            xhrObj.setRequestHeader("Ocp-Apim-Subscription-Key",apiKey)
        }
    })
    .done( success => {
        alert('Grupo Treinado com sucesso!')
    })
    .fail( error => {
        alert(error)
        console.log(error)
    })
}

