
<body>

    <body>

        <style>
            .containner-form {
                height: 100%;
                margin: 25%;
            }

            .form-recuperar {
                display: flex;
                flex-direction: column;
            }

            #inputNome,
            #inputCPF,
            #inputEmail {
                margin-bottom: 10px;
                padding: 10px;
            }

            .btn-3 {
                background-color: black;
                color: white;
                cursor: pointer;
                padding: 10px;
            }

            .btn-3:hover {
                background-color: #555;
            }
        </style>

        <div class="containner-form">

            <div>
                <span style="margin-bottom: 5px; font-weight: bold;">Recuperar dados</span>


                <form action="https://api.staticforms.xyz/submit" method="post" class="form-recuperar">
                    <input type="hidden" name="accessKey" value="fc7e6848-98e2-4c3f-865a-4bfc03402312">
                    <input type="hidden" name="redirectTo" value="https://localhost/loja-personalizada/cliente/sheep_enviado.php">
                    <input type="hidden" name="name" id="inputNome" value="Recuperação da Senha do Cliente:" />
                    <input type="text" name="name" id="inputNome" placeholder="Nome Completo" required />
                    <input type="text" name="name" id="inputCPF" placeholder="CPF" required />
                    <input type="text" name="email" id="inputEmail" placeholder="E-mail para contato" required />
                    <input type="hidden" name="subject" value="senha/email" />
                    <input type="submit" value="Enviar" class="btn-3" />

                </form>
            </div>

        </div>

    </body>