

<body>
    <div class="minha-conta">
        <div class="containner-conta">
            <style>
                .CadastroSite-2 {
                    display: flex;
                    flex-direction: column;
                   margin-top: 200px;
                    font-size: 35px;
                    font-weight: bold;
                }

                .sucess {
                    line-height: 70px;
                    text-align: center;
                }

                .volta {
                    height: 50px;
                    font-size: 30px;
                   padding: 5px;
                    background-color: black;
                    color: white;
                    border-radius: 8px;
                    cursor: pointer;
                }

                .volta:hover {
                    background-color: #555;
                }
            </style>
            <div class="linha">
                <div class="col-2">
                    <div class="formulario">

                        <div class="btn-form CadastroSite-2 ">

                            <div>
                                <h1 style="text-align: center; color:green">Enviado com Sucesso</h1>
                                <br>

                                <p class="sucess">Em breve você Recebera um E-mail com seu e-mail cadastrado e uma Senha provisória, após acessar o<br>
                                 painel crie uma nova senha<br><br><br>
                                    <a href="<?=HOME ?>">
                                        <button class="volta">Voltar ao Site</button>
                                    </a>
                                </p>
                            </div>

                        </div>

                    </div>

                </div>

            </div>
        </div>
    </div>
</body>

</html>