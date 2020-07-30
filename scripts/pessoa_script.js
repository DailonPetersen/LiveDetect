const apiKey = "f4393d4b42804052aa3915ffb0026b24"
const apiUrl = "https://dailonpetersenftec.cognitiveservices.azure.com/face/v1.0/"

$('select').change( () => {
    var nome = $('#name').val()
    var grupo = $('#id_grupo option:selected').text()
    var info = $('#userData').val()
    console.log(nome, grupo, info)
    createPerson(grupo, nome, info)
})

function createPerson(grupo, nome, info){
        
    const data = {
        "name": nome,
        "userData": info
    }

    console.log(JSON.stringify(data))
    $.ajax({
        type: 'POST',
        url: `https://dailonpetersenftec.cognitiveservices.azure.com/face/v1.0/persongroups/${grupo}/persons`,
        beforeSend: xhrObj => {
            xhrObj.setRequestHeader("Content-Type","application/json")
            xhrObj.setRequestHeader("Ocp-Apim-Subscription-Key", "f4393d4b42804052aa3915ffb0026b24")
        },
        data: JSON.stringify(data)
    })
    .done(function (response) {
        $('#personId').val(response['personId'])
    })
    .fail(function (error) {
        console.error(error)
    });
    
}

function salvarPessoa(valorBotao) {

    var nome = $('#name').val()
    var grupo = $('#id_grupo option:selected').text()
    var info = $('#userData').val()
    var personId = $('#personId').val()

    if (personId == ''){
        createPerson(grupo,nome, info)
    }


    if ( valorBotao == 'Cadastrar' ){
        createPessoaDB(nome, grupo, info, personId)
    } else if ( valorBotao == 'Atualizar') {
        updatePessoaDB(nome, info)
    }
}

function createPessoaDB(nome, grupo, info, personId){


    const data = {
        "name": nome,
        "userData": info,
        "id_grupo": grupo,
        "personId": personId,
    }

    $.ajax({
        url:'cad_pessoa.php',
        type: 'POST',
        data: data,
        async: true
    })
    .done( success => {
        window.location.href = `http://localhost/livedetect2/index.php?p=edit_pessoa&edit_person_id=${personId}&group_id=${grupo}`
    })
    .fail( error => {
        console.log('nao salvou')
    })
}

function realizaUpload(file, personId){

    const data = new FormData()

    data.append('enviar','ok')
    data.append('inputImagem', file)
    data.append('personId', personId)

    console.log(data)

    $.ajax({
        url: 'edit_pessoa.php',
        type: 'post',
        data: data,
        async: true,
        contentType: false,
        processData: false,
    })
    .done(function (response) {
        alert("Upload Ok")
    })
    .fail(function (error) {
        console.error(error)
    });
}
             

async function AddFaceToPerson() {

    //window.location.search eh a url
    const urlParams = new URLSearchParams(window.location.search)
    personId = urlParams.get('edit_person_id')
    groupId = urlParams.get('group_id')

    //quantidade de imagens selecionadas
    var length = document.getElementById('inputImagem').files.length
    for ( let i = 0; i<length; i++) {

        //pega as imagens a partir do campo
        file = document.getElementById('inputImagem').files[i]

        realizaUpload(file, personId)

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
            alert("Imagem adicionada com sucesso!")
        })
        .fail(function (error) {
            console.error(error)
        });
    }
    window.location.href = "http://localhost/livedetect2/index.php?p=cad_pessoa"
}