<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cliente</title>
</head>
<body>
    <output></output>
    <input></input>
    <input type="text" />

    <script>
        const ws = new WebSocket("ws://localhost/");
        const input = document.querySelector('input');
        const output = document.querySelector('output');

        ws.addEventListener('open', console.log);
        ws.addEventListener('message', console.log);
        
        ws.addEventListener('message', message => {
            const dados = JSON.parse(message.data);
            if(dados.type === 'chat'){
                output.append('Outro: ' + dados.text, document.createElement('br'));
            }
        });


        ws.addEventListener('keypress', e => {
            if(e.code === 'Enter'){
                const valor = input.value;
                output.append('Eu: ' + dados.text, document.createElement('br'));
                ws.send(valor);
                input.value = '';
            }
        });


    </script>
</body>
</html>