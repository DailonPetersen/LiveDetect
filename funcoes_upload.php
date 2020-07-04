<?php
    function mostrarErroPublicacao($numero) {
        $array_erro = array(
            UPLOAD_ERR_OK => "não houve erro, o upload foi bem sucedido.",
            UPLOAD_ERR_INI_SIZE => " O arquivo enviado excede o limite definido.",
            UPLOAD_ERR_FORM_SIZE => "O arquivo excede o tamanho limite definido.",
            UPLOAD_ERR_PARTIAL => "O upload do arquivo foi feito parcialmente",
            UPLOAD_ERR_NO_FILE => " Nenhum arquivo foi enviado",
            UPLOAD_ERR_NO_TMP_DIR => "Pasta temporária ausênte",
            UPLOAD_ERR_CANT_WRITE => "Falha em escrever o arquivo em disco",
            UPLOAD_ERR_EXTENSION => "Uma extensão do PHP interrompeu o upload do arquivo"
        );
    }
    
    function geraNome($personId) {
        date_default_timezone_set('America/Sao_Paulo');

        $agora = getdate();

        $cod_data = $agora['hours'].$agora['minutes'].$agora['seconds'].".";
        $cod_data .= $agora['yday']."_".$agora['year'];
        return $personId."_".$cod_data;
    }

    function pegaExtensao($nome_original){
        return strrchr($nome_original, ".");
    }

    function publicarArquivo($imagem, $personId){
    
        $arquivo_temporario = $imagem['tmp_name'];
        $nome_original = basename($imagem['name']);

        $dir = "uploads";

        $nome_final = geraNome($personId).pegaExtensao($nome_original);
    
        if (move_uploaded_file($arquivo_temporario, $dir . "\\" . $nome_final)) {
            $msg = "Arquivo movido com sucesso!";
            return $msg;
        } else {
            $num_erro = $imagem['error'];
            $msg = mostrarErroPublicacao($num_erro);
            return $msg;
        };

    }
?>