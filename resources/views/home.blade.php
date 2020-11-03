@extends('layouts.app')

@section('content')

<div class="container">
    <div class=" d-flex justify-content-end" style="margin-bottom: 2%;">

            <div class="col-md-4">

                <div class="input-group mb-3">
                    <input type="text" class="form-control" id="pesquisar" placeholder="Pesquisar..." >
                    <div class="input-group-append">
                      <button class="btn btn-outline-secondary" onclick="pesquisar()" type="button" ><i class="fas fa-search"></i></button>
                    </div>
                </div>

            </div>

            <div class="col-md-2">
            <input type="hidden" id="permissao" name="permissao" value="{{Auth::user()->tipoUsuario}}">
            @if(Auth::user()->tipoUsuario==1)
                <button class="btn btn-success text-nowrap"  onclick="cadastrarEvento()">Cadastrar Evento</button>
            @endif
            </div>

    </div>
    <div class="row d-flex justify-content-center col-md-12" id="eventos">



    </div>

    <div class="modal fade bd-example-modal-lg" id="visualizarMais" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog  modal-dialog-centered">
          <div class="modal-content" id="umEvento">

          </div>
        </div>
      </div>

    <div class="modal fade" id="cadastrarEventos" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title d-flex justify-content-center" id="exampleModalLabel">Novo evento</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="custId" name="custId" value="">
              <form enctype="multipart/form-data">
                <div class="form-group">

                  <label for="recipient-name" class="col-form-label">Nome</label>
                  <input type="text" class="form-control" id="nome">

                </div>
                <div class="form-group form-row">

                    <div class="col-md-6">
                        <label for="">Data inicio</label>
                        <input type="date" class="form-control" id="dataInicio">

                    </div>

                    <div class="col-md-6">
                        <label for="">Data fim</label>
                        <input type="date" class="form-control" id="dataFim">

                    </div>

                </div>

                <div class="form-group form-row">
                    <div class="col-md-4">
                        <label for="" class="col-form-label">Estado</label>
                        <select class="form-control" id="estado" name="estado">
                            <option value="AC">Acre</option>
                            <option value="AL">Alagoas</option>
                            <option value="AP">Amapá</option>
                            <option value="AM">Amazonas</option>
                            <option value="BA">Bahia</option>
                            <option value="CE">Ceará</option>
                            <option value="DF">Distrito Federal</option>
                            <option value="ES">Espírito Santo</option>
                            <option value="GO">Goiás</option>
                            <option value="MA">Maranhão</option>
                            <option value="MT">Mato Grosso</option>
                            <option value="MS">Mato Grosso do Sul</option>
                            <option value="MG">Minas Gerais</option>
                            <option value="PA">Pará</option>
                            <option value="PB">Paraíba</option>
                            <option value="PR">Paraná</option>
                            <option value="PE">Pernambuco</option>
                            <option value="PI">Piauí</option>
                            <option value="RJ">Rio de Janeiro</option>
                            <option value="RN">Rio Grande do Norte</option>
                            <option value="RS">Rio Grande do Sul</option>
                            <option value="RO">Rondônia</option>
                            <option value="RR">Roraima</option>
                            <option value="SC">Santa Catarina</option>
                            <option value="SP">São Paulo</option>
                            <option value="SE">Sergipe</option>
                            <option value="TO">Tocantins</option>
                            <option value="EX">Estrangeiro</option>
                        </select>
                    </div>

                    <div class="col-md-8">
                        <label for="" class="col-form-label">Cidade</label>
                        <input type="text" class="form-control" id="cidade">
                    </div>

                </div>

                <div class="form-group">
                    <label for="" class="col-form-label">Endereço</label>
                    <input type="text" class="form-control" id="endereco">
                </div>

                <div class="custom-file">
                    <label>Escolha uma imagem para o evento</label>
                    <input type="file" name="foto" class="form-control">
                </div>

              </form>
            </div>
            <div class="modal-footer d-flex justify-content-center">

              <button type="button" class="btn btn-primary"  id="enviar">Enviar</button>
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>

            </div>
          </div>
        </div>
      </div>
</div>
<script>

    function pesquisar(){
        carregarEventos();
    }

    function carregarEventos(){
        $('#eventos').empty();
        dados = {
                "nomeEvento": $('#pesquisar').val()
            }
        $.get("/api/v1/evento",dados, function(data, status){

                for(const evento of data){

                    $("#eventos").append(
                        `<div class="col-md-4" id="aux">
                            <div class="card mb-4 shadow-sm" onclick="visualizar(${evento.id})">
                                <img src="{{asset('logos/compacto_logo.png')}}" width="100%" alt="">
                            </div>
                        </div>`
                    )
                }

            })
    }

    $(function(){
        carregarEventos();
    })

    function cadastrarEvento(){
        document.getElementById('nome').value='';
        document.getElementById('dataInicio').value='';
        document.getElementById('dataFim').value='';
        document.getElementById('cidade').value='';
        document.getElementById('endereco').value='';
        document.getElementById('custId').value='';

        $('#cadastrarEventos').modal('show')
    }

    $('#enviar').click(function(event){

        event.preventDefault();
        dados = {
            "nomeEvento": $('#nome').val(),
            "inicio": $('#dataInicio').val(),
            "termino": $('#dataFim').val(),
            "estado": $('#estado').val(),
            "cidade": $('#cidade').val(),
            "endereco": $('#endereco').val(),
            "imagem": $('#imagem').val(),
        }
        if($('#custId').val()==""){

            $.post("api/v1/evento", dados, function(data, status, xhr){

                carregarEventos();
                $('#cadastrarEventos').modal('hide')
            })

        }else{
            $.ajax({ url: `api/v1/evento/${$('#custId').val()}`, method: 'PUT', data:dados})
            .then(resp=>{

                $('#cadastrarEventos').modal('hide')
                carregarEventos();
            });
        }

    })

    function editarEvento(id){
        $.get(`/api/v1/evento/${id}`, function(data, status){

            document.getElementById('nome').value=data.nomeEvento;
            document.getElementById('dataInicio').value=data.inicio;
            document.getElementById('dataFim').value=data.termino;
            document.getElementById('cidade').value=data.cidade;
            document.getElementById('endereco').value=data.endereco;
            document.getElementById('custId').value=data.id;
        })
        $('#visualizarMais').modal('hide');
        $('#cadastrarEventos').modal('show');
    }

    function deletar(id){
        $.ajax({ url: `/api/v1/evento/${id}`, method: 'DELETE'})
            .then(resp=>{
                $('#visualizarMais').modal('hide');
                carregarEventos();
            });
    }

    function acessos(id){

        $.ajax({ url: `/api/v1/evento/acessos/${id}`, method: 'PUT'})
            .then(resp=>{
                carregarEventos();
            });
    }

    function visualizar(id){
        $.get(`/api/v1/evento/${id}`, function(data, status){
            $('#umEvento').empty();

            $("#umEvento").append(`
            <div class="card shadow-sm modal-body ">
                <div class="d-flex justify-content-center">
                    <img src="{{asset('logos/compacto_logo.png')}}" style="width:100%;  height: 350px" alt="">

                </div>

            </div>
            <div class="row ">
                    <div class="col-md-8 ">
                        <h5>Nome: ${data.nomeEvento}</h5>
                        <h5>Inicio: ${data.inicio}</h5>
                        <h5>Fim: ${data.termino}</h5>
                        <h5>Estados: ${data.estado} </h5>
                        <h5>Cidade: ${data.cidade}</h5>
                        <h5>Local: ${data.endereco} </h5>
                    </div>

                    <div class="col-md-4 form-row d-flex align-items-end" >
                        <div>
                            <button class="btn btn-outline-danger" onclick="acessos(${data.id})" style="margin-left:5%;"><i class="far fa-heart"></i></button>
                        </div>
                        <div id="deletarEditar">

                        </div>
                    </div>

            </div>
            `)
            if($('#permissao').val()==1){
                $('#deletarEditar').empty();
                $("#deletarEditar").append(`
                <button class="btn btn-info" onclick="editarEvento(${data.id})"><i class="far fa-edit"></i></button>
                <button class="btn btn-danger" onclick="deletar(${data.id})"><i class="far fa-trash-alt"></i></button>`)
            }
        });
        $('#visualizarMais').modal('show');
    }

</script>
@endsection
