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
    alert(JSON.stringify(data))
    $.ajax({
        url:'cad_pessoa.php',
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
