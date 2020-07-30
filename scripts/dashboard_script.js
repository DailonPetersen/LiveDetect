$('#grupos').change( () => {

    var grupo = $('#grupos option:selected').text()

    $.ajax({
        type: 'GET',
        url: `https://dailonpetersenftec.cognitiveservices.azure.com/face/v1.0/persongroups/${grupo}/persons`,
        beforeSend: xhrObj => {
            xhrObj.setRequestHeader("Ocp-Apim-Subscription-Key", "f4393d4b42804052aa3915ffb0026b24");
        }
    })
    .done(function (response) {
        criaSelectPessoas(response)
    })
    .fail(function (error) {
        console.error(error)
    });

    function criaSelectPessoas(pessoas){
        pessoas.forEach((pessoa) => {
            $('#pessoas').append(
                `<option>${pessoa['name']} - ${pessoa['personId']}</option>`
            )
        })
    }

})

$('#buscaEmocaoinstituição/empresa').click( () => {
    var pessoa = $('#pessoas option:selected').text()
    var r = pessoa.split("- ")
    console.log(r[1])


    
    $.ajax({
        type:'POST',
        url: 'dashboard.php',
        data: { 'personId':r[1]},
        async: true
    })
    .done(function (response) {
        console.log(response)
    })
    .fail(function (error) {
        console.error(error)
    });
})

function updateChart(){



    chart.update();
}