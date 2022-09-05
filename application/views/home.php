<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <!-- bootstrap -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="aplicação web para buscar endereço por cep">
    <meta name="author" content="Cristian Marques">
    <link rel="shortcut icon" href="assets/bootstrap/img/logo-fav.png">
    <title>Busca por CEP</title>
    <link rel="stylesheet" type="text/css" href="assets/bootstrap/lib/perfect-scrollbar/css/perfect-scrollbar.min.css"/>
    <link rel="stylesheet" type="text/css" href="assets/bootstrap/lib/material-design-icons/css/material-design-iconic-font.min.css"/><
    <link rel="stylesheet" href="assets/bootstrap/css/style.css" type="text/css"/>
    <!-- fim bootstrap -->

    <!-- Adicionando JQuery -->
    <script src="//code.jquery.com/jquery-2.2.2.min.js"></script>

    <!-- Adicionando Javascript -->
    <script type="text/javascript" >

      $(function(){
            function limpa_formulário_cep() {
                // Limpa valores do formulário de cep.
                $("#cep").val("");
                $("#rua").val("");
                $("#bairro").val("");
                $("#cidade").val("");
                $("#estado").val("");
                $("#ibge").val("");
                $('#cep').focus();                
            }

            $("#btn_consulta").click(function(){
                var cep = $('#cep').val();
                if (cep == '') {
                    alert('Informe o CEP antes de continuar');
                    $('#cep').focus();
                    return false;
                } else if (cep != "") {

                    //Expressão regular para validar o CEP.
                    var validacep = /^[0-9]{8}$/;

                    //remove ponto e virgula do cep
                    cep = cep.replace(/\.|\-/g, '');

                    //Valida o formato do CEP.
                    if(validacep.test(cep)) {

                        //Preenche os campos com "..." enquanto consulta webservice.
                        $("#rua").val("...");
                        $("#bairro").val("...");
                        $("#cidade").val("...");
                        $("#uf").val("...");
                        $("#ibge").val("...");

                    } else {
                        //cep é inválido.
                        limpa_formulário_cep();
                        alert("Formato de CEP inválido.");
                    }
                } //end if.
                else {
                    //cep sem valor, limpa formulário.
                    limpa_formulário_cep();
                }     
                $('#btn_consulta').html ('Aguarde...');         

                //vai fazer a consulta no controller
                $.post('index.php/home/consulta',
                {
                    cep : cep
                }, 
                function(dados){
                  console.log('dados: ',dados);
                  //console.log(dados.msg);die();
                  if(dados.msg == 'viacep'){
                    alert('Dados vindos da ViaCep. Inserido no banco local com Sucesso!');
                  }else{
                    alert('Pesquisa direto do banco local!');
                  }

                    $('#rua').val(dados.logradouro);
                    $('#bairro').val(dados.bairro);
                    $('#cidade').val(dados.localidade);
                    $('#estado').val(dados.uf);
                    $('#btn_consulta').html('Consultar');
                }, 'json');

            });

            $('#btn_limpar').click(function(){
              $("#cep").val("");
              $("#rua").val("");
              $("#bairro").val("");
              $("#cidade").val("");
              $("#estado").val("");
              $("#ibge").val("");
              $('#cep').focus();
            });          

        });



    </script>

</head>
<body>

<div id="container">
  <nav class="navbar navbar-default navbar-fixed-top be-top-header">
        <div class="container-fluid">
          <div class="navbar-header"><img src="assets/bootstrap/img/logo.png"></div>
          <div class="be-right-navbar">
            <ul class="nav navbar-nav navbar-right be-user-nav">
              <li class="dropdown"><a href="#" data-toggle="dropdown" role="button" aria-expanded="false" class="dropdown-toggle"><img src="assets/bootstrap/img/avatar1.png" alt="Avatar"><span class="user-name">Cristian Marques</span></a>
                <ul role="menu" class="dropdown-menu">
                  <li>
                    <div class="user-info">
                      <div class="user-name">Cristian Marques</div>
                      <div class="user-position online">Available</div>
                    </div>
                  </li>
                  <li><a href="#"><span class="icon mdi mdi-face"></span> Conta</a></li>
                  <li><a href="#"><span class="icon mdi mdi-settings"></span> Configurações</a></li>
                  <li><a href="#"><span class="icon mdi mdi-power"></span> Sair</a></li>
                </ul>
              </li>
            </ul>
            <div class="page-title"><span>Consulta ViaCep</span></div>
            <ul class="nav navbar-nav navbar-right be-icons-nav">
              <li class="dropdown"><a href="#" role="button" aria-expanded="false" class="be-toggle-right-sidebar"><span class="icon mdi mdi-settings"></span></a></li>
              <li class="dropdown"><a href="#" data-toggle="dropdown" role="button" aria-expanded="false" class="dropdown-toggle"><span class="icon mdi mdi-notifications"></span><span class="indicator"></span></a>
                <ul class="dropdown-menu be-notifications">
                  <li>
                    <div class="title">Notificações<span class="badge">3</span></div>
                    <div class="list">
                      <div class="be-scroller">
                        <div class="content">
                          <ul>
                            <li class="notification notification-unread"><a href="#">
                                <div class="image"><img src="assets/bootstrap/img/avatar2.png" alt="Avatar"></div>
                                <div class="notification-info">
                                  <div class="text"><span class="user-name">Jessica Caruso</span> Aceitar Convite.</div><span class="date">2 min ago</span>
                                </div></a></li>
                            <li class="notification"><a href="#">
                                <div class="image"><img src="assets/bootstrap/img/avatar3.png" alt="Avatar"></div>
                                <div class="notification-info">
                                  <div class="text"><span class="user-name">Joel King</span> esta te seguindo agora</div><span class="date">2 days ago</span>
                                </div></a></li>
                            <li class="notification"><a href="#">
                                <div class="image"><img src="assets/bootstrap/img/avatar4.png" alt="Avatar"></div>
                                <div class="notification-info">
                                  <div class="text"><span class="user-name">John Doe</span>está assistindo seu repositório principal</div><span class="date">2 days ago</span>
                                </div></a></li>
                            <li class="notification"><a href="#">
                                <div class="image"><img src="assets/bootstrap/img/avatar5.png" alt="Avatar"></div>
                                <div class="notification-info"><span class="text"><span class="user-name">Emily Carter</span> esta seguindo você agora</span><span class="date">5 days ago</span></div></a></li>
                          </ul>
                        </div>
                      </div>
                    </div>
                    <div class="footer"> <a href="#">Ver todas as notificações</a></div>
                  </li>
                </ul>
              </li>
              <li class="dropdown"><a href="#" data-toggle="dropdown" role="button" aria-expanded="false" class="dropdown-toggle"><span class="icon mdi mdi-apps"></span></a>
                <ul class="dropdown-menu be-connections">
                  <li>
                    <div class="list">
                      <div class="content">
                        <div class="row">
                          <div class="col-xs-4"><a href="https://github.com/cristianwk/PHPtest" class="connection-item"><img src="assets/bootstrap/img/github.png" alt="Github"><span>GitHub</span></a></div>
                          <div class="col-xs-4"><a href="#" class="connection-item"><img src="assets/bootstrap/img/bitbucket.png" alt="Bitbucket"><span>Bitbucket</span></a></div>
                          <div class="col-xs-4"><a href="http://wkgrupo.slack.com" class="connection-item"><img src="assets/bootstrap/img/slack.png" alt="Slack"><span>Slack</span></a></div>
                        </div>
                      </div>
                    </div>
                    <div class="footer"> <a href="#">Mais</a></div>
                  </li>
                </ul>
              </li>
            </ul>
          </div>
        </div>
      </nav>

  <div id="body">
      <div class="page-head" style="padding-top: 44px;">
        <h2 class="page-head-title">Pesquisar</h2>
        <ol class="breadcrumb page-head-nav">
          <li><a href="#">Home</a></li>
          <li><a href="#">Forms</a></li>
          <li class="active">Pesquisa</li>
        </ol>
      </div> 
  
<div class="main-content container-fluid">
          <div class="row">
            <div class="col-md-12">
              <div class="panel panel-default panel-border-color panel-border-color-primary">
                <div class="panel panel-default">
                <div class="panel-heading">
                    Digite o CEP desejado
                </div>
                <div class="panel-body">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="cep">CEP:</label>
                            <input type="text" name="cep" id="cep" class="form-control" autofocus required placeholder="Somente os números do CEP" />
                        </div>
                        <div class="form-group">
                            <button id="btn_consulta" class="btn btn-success">Consultar</button>
                            <button id="btn_limpar" class="btn btn-warning">Limpar</button>
                        </div>
                        <div class="form-group">
                            <label for="rua">Rua:</label>
                            <input type="text" name="rua" id="rua" value="<?php if(@$endereco->rua != '') {echo @$endereco->rua;} ?>" class="form-control" disabled required />
                        </div>
                        <div class="form-group">
                            <label for="bairro">Bairro:</label>
                            <input type="text" name="bairro" id="bairro" value="<?php if(@$endereco->bairro != '') { echo @$endereco->bairro;} ?>" class="form-control" disabled  required />
                        </div>
                        <div class="form-group">
                            <label for="cidade">Cidade:</label>
                            <input type="text" name="cidade" id="cidade" value="<?php if(@$endereco->cidade != '') {echo @$endereco->cidade;} ?>" class="form-control"  disabled required />
                        </div>
                        <div class="form-group">
                            <label for="estado">Estado:</label>
                            <input type="text" name="estado" id="estado" value="<?php if(@$endereco->estado != '') { echo @$endereco->estado;} ?>" class="form-control"  disabled required size="2"/>
                        </div>
                    </div>
                </div>
            </div>
              </div>
            </div>
          </div>
        </div>
  </div>

  <p class="footer">Page rendered in <strong>{elapsed_time}</strong> seconds. <?php echo  (ENVIRONMENT === 'development') ?  'CodeIgniter Version <strong>' . CI_VERSION . '</strong>' : '' ?></p>
</div>

    <script src="assets/bootstrap/lib/jquery/jquery.min.js" type="text/javascript"></script>
    <script src="assets/bootstrap/lib/perfect-scrollbar/js/perfect-scrollbar.jquery.min.js" type="text/javascript"></script>
    <script src="assets/bootstrap/js/main.js" type="text/javascript"></script>
    <script src="assets/bootstrap/lib/bootstrap/dist/js/bootstrap.min.js" type="text/javascript"></script>
    <script src="assets/bootstrap/lib/jquery.maskedinput/jquery.maskedinput.min.js" type="text/javascript"></script>
    <script src="assets/bootstrap/js/app-form-masks.js" type="text/javascript"></script>
    <script src="assets/bootstrap/js/personalizado.js"></script>
    <script type="text/javascript">
      $(document).ready(function(){
        //initialize the javascript
        App.init();
        App.masks();
      });
    </script>
  </body>
</html>