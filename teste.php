<?php

if(is_file(__DIR__."/crt/certificate.crt")){
    echo "Arquivo local certo";
}else{
    echo "Arquivo local Errado";
    echo "\n";
    echo __DIR__;

}