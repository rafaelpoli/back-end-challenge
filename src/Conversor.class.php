<?php

namespace App;

class Conversor {
    public $simbolos = array(
        'BRL' => 'R$',
        'USD' => 'USD',
        'EUR' => '€'
    );
    public $valorde;
    public $valorConvertido; 
    public $moedade;
    public $moedapara;
    public $cambio;
    public $returnCode;
    public $conteudo;

    function __contruct(array $endpoints){
        if( isset( $endpoints[2] )) $this->valorde = $endpoints[2]; else $this->returnCode = 400;
        if( isset( $endpoints[3] )) $this->moedade = $endpoints[3]; else $this->returnCode = 400;
        if( isset( $endpoints[4] )) $this->moedapara = $endpoints[4]; else $this->returnCode = 400;
        if( isset( $endpoints[5] )) $this->cambio = $endpoints[5]; else $this->returnCode = 400;
        $this->validarDados();   
    }

    public function validarDados(){
        if(!is_numeric($this->valorde) || !is_numeric($this->cambio) || !ctype_upper($this->moedade) || !ctype_upper($this->moedapara))
            $this->returnCode = 400;
        if($this->valorde < 0 || $this->cambio < 0)
            $this->returnCode = 400;
        if( $this->moedade != 'BRL' || $this->moedade != 'USD' || $this->moedade != 'EUR')
            $this->returnCode = 400;
        if( $this->moedapara != 'BRL' || $this->moedapara != 'USD' || $this->moedapara != 'EUR')
            $this->returnCode = 400;        
        $this->converter();
    }

    public function converter() {
        $this->returnCode = 200;
        $this->valorConvertido = $this->valorde * $this->cambio;
        $this->conteudo = [ 'valorConvertido' => $this->valorConvertido, 'simboloMoeda' => $this->simbolos[ $this->moedapara ]];
        return;
    }

    public function retornarCode() {
        http_response_code( $this->returnCode );
    }


    public function retornarConteudo() {        
        header( 'Content-Type: application/json; charset=utf-8' );        
        echo json_encode( $this->conteudo, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE );        
    }


}

