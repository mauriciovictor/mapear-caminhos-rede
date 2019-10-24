
<?php  
   
   if(isset($_POST['grupo']) && isset($_POST['elemento']) && isset($_POST['link'])){
        setGrupoElemento($_POST['grupo'],$_POST['elemento'],$_POST['link']);
   }  
   
   function setGrupo($nome_grupo ){
         $arquivo = file_get_contents('grupos.json');
  
         $json = json_decode($arquivo, true);
         
       
         $novoID = 1;
         
         foreach($json["Grupos"] as $j){
           $novoID++;
         }
          
          $teste["id"] = $novoID;
          $teste["nome"] = $nome_grupo;

          array_push($json["Grupos"], $teste);

           $fp = fopen('grupos.json', 'w');

           fwrite($fp, json_encode($json));
   }

   function setGrupoElemento($id_grupo, $nome_elemento, $link){

         $arquivo = file_get_contents('grupos_elementos.json');
  
         $json = json_decode($arquivo, true);
         
       
         $novoID = 1;
         
         foreach($json["GruposElementos"] as $j){
           $novoID++;
         }

          $novoElemento["nome"]     = $nome_elemento;
          $novoElemento["Link"]     = $link;
          $novoElemento['grupo_id'] = $id_grupo;
          
          array_push($json["GruposElementos"], $novoElemento);

          $fp = fopen('grupos_elementos.json', 'w');

          fwrite($fp, json_encode($json));
      
   }
   
    function alterarGrupoElementos($elemento, $id_grupo, $nome, $link){
            $arquivo = file_get_contents('grupos_elementos.json');
  
            $json = json_decode($arquivo, true);
             
            $json["GruposElementos"][$elemento]["nome"]     = $nome;
            $json["GruposElementos"][$elemento]["Link"]     = $link;
            $json["GruposElementos"][$elemento]["grupo_id"] = $id_grupo;
            
            $fp = fopen('grupos_elementos.json', 'w');

            fwrite($fp, json_encode($json));

        }

        function ExcluirGrupoElemento($elemento){
            $arquivo = file_get_contents('grupos_elementos.json');
  
            $json = json_decode($arquivo, true);

            unset($json["GruposElementos"][$elemento]);

            $fp = fopen('grupos_elementos.json', 'w');

            fwrite($fp, json_encode($json));


        }   
    // setGrupoElemento(2, "teste", "http://wwww.google.com");
  
?>

<!DOCTYPE html>
<html lang="pt-br">
  <head>
  	 <title> Sistemas </title>
  	 <meta charset="utf-8">
  	 <link rel="stylesheet" href="assets/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

     <style>
       body{
         font-family: arial, sans-serif, times new roman, segoi ui;
         font-size: 15px;
         font-style: normal; /* italic */
         font-weight: bold; 
       }
       .btn-acoes-edit{
          background-color: #bf8e06;
          border-radius: 4px;
          padding:2px;
       }
       .btn-acoes-edit:hover{
          background-color: #c9a659;
       }
       
       .btn-acoes-delete{
          background-color: #ad4a23;
          border-radius: 4px;
          padding:2px;
       }
       .btn-acoes-delete:hover{
          background-color: #b56a4c;
       }
       .svg{
          color:red;
       }

       .list-group-item{
           transition: padding-bottom 0.3s, background-color 1s;
       }

       .li-item:hover{
          background-color: #eee; 
          padding:25px;
          transition: all 10s. linear;
          transition: padding-bottom 0.3s, background-color 1s;
          /*transform: rotate(180deg);*/
       }

     </style>
     <script>
     var elemento ;
     var elementoValue;
        function getElemento(id){
          elemento       = document.querySelector(`a[id="${id}"`);
          var elementoValue  = JSON.parse(elemento.getAttribute("value"));
          console.log(elementoValue);
          elementoValue.id_grupo;
          elementoValue.chave;
          elementoValue.nome;
          var elementoLink   = elemento.getAttribute("href");
          
          document.querySelector(`option[id="${elementoValue.id_grupo}"]`).selected = true;
          document.querySelector("input[id='nome2']").setAttribute("value", elementoValue.nome);
          document.querySelector("input[id='link2']").setAttribute("value", elementoLink);
          document.querySelector("input[id='chave_alterar']").setAttribute("value", elementoValue.chave);


          document.querySelector("input[id='nome1']").setAttribute("value", elementoValue.nome);
          document.querySelector("input[id='link1']").setAttribute("value", elementoLink);
          document.querySelector("input[id='chave']").setAttribute("value", elementoValue.chave);

          // console.log("ddd"+elemento, elementoValue.id_grupo, elementoValue.chave, elementoLink, elementoValue.nome);
        }
     </script>
  </head>
  <body>  
    <?php
      $arquivo = file_get_contents('grupos.json');
      $json = json_decode($arquivo);

      $arquivoElementos = file_get_contents('grupos_elementos.json');
      $Elementos = json_decode($arquivoElementos, true);
    ?> 

  	<div class="container" style="margin-top: 30px; ">
      <div class="row">
        <div class="col-md-2">
        </div>
        <div class="col-md-8">
          <div class="alert alert-danger alert-dismissible fade show" role="alert" style="display:none;">
             <strong>Favor !</strong> Preencha todos os campos <h5 style="display:inline;"> :)</h5>
             <button type="button" class="close" data-dismiss="alert" aria-label="Close">
             <span aria-hidden="true">&times;</span>
            </button>
          </div>
        </div> 
        <div class="col-md-2">
        </div> 
      </div> 
      <form method="post" action="index.php">
      <div class="row">
            <div class="col-md-4">
                    <select class="custom-select custom-select-lg mb-3" name="grupo_inserir">
                      <option selected>Selecionar Grupo</option>
                        <?php foreach($json->Grupos as $grupos): ?>
                        
                          <option value="<?php echo $grupos->id ?>"> <?php echo $grupos->nome ?></option>
                        
                        <?php  endforeach; ?>
                    </select> 
            </div>    
            <div class="col-md-3">
                    <input text="text" class="form-control" placeholder="Nome do Elemento" style="height:48px;"name="elemento_inserir">
            </div>
            <div class="col-md-3" >
                    <input text="text" class="form-control" placeholder="Link Elemento" style="height:48px;"name="link_inserir">
            </div>    
            <div class="col-md-2">
                    <button type="submit" name="submit" value="salvar" class="btn btn-success" style="height:48px;"> Salvar </button>
            </div> 
      </div> 
      </form> 
  	  <div class="row">

        <?php foreach($json->Grupos as $grupos): ?>
            <div class="col-md-4">   
                <ul class="list-group bg-success" style="border-radius : 5px; box-shadow: 1px 4px 5px 2px rgba(0, 0, 0, 0.2); ">
                  <li class="list-group-item active"><?php echo $grupos->nome?></li>
                    <?php foreach($Elementos["GruposElementos"] as $key => $value): ?>
                       <?php if  ($grupos->id == $value["grupo_id"]): ?>
                          <li class="list-group-item li-item"> 
                            <?php $json1 = '{"id_grupo":"'.$grupos->id.'",'.'"chave" :'.$key.','.'"'.'nome"'.':"'.$value["nome"].'"}';?>
                             <a href="<?php echo $value['Link'] ?>"> <?php echo $value["nome"] ?> </a>
                             
                             <a class="btn-acoes-delete" id = "<?php echo $key; ?>" href="<?php echo $value['Link'] ?>" value='<?php echo $json1;?>' onclick="getElemento(this.id);" data-toggle="modal" data-target="#delete" style="position:relative; top:-3px; float: right; margin:1px;"> <img src="assets/images/delete.svg" width="22"> </a>

                            <a class="btn-acoes-edit" id = "<?php echo $key; ?>" href="<?php echo $value['Link'] ?>" value='<?php echo $json1;?>' onclick="getElemento(this.id);" data-toggle="modal" data-target="#example" style="position:relative; top:-3px; float: right; margin:1px;"> <img class="svg" src="assets/images/edit.svg" width="22"> </a>
                           
                          </li>
                       <?php endif?>
                    <?php  endforeach; ?>  
              </ul>
            </div>
        <?php  endforeach; ?>
		  </div>  
	  </div>
	</div> 

<form method="post" action='index.php'>

    <div class="modal fade" id="example" tabindex="-1" role="dialog" aria-labelledby="example" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalCenterTitle">Alterar</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          
           <select class="custom-select custom-select-lg mb-3" name="grupo">
                    <?php foreach($json->Grupos as $grupos): ?>
                    
                      <option id ="<?php echo $grupos->id ?>" value="<?php echo $grupos->id ?>"> <?php echo $grupos->nome ?></option>
                    
                    <?php  endforeach; ?>
                </select>
                <input id="nome2" name="nome1" type="text" style="margin-bottom: 3px;" class="form-control" placeholder="Nome">
                <input id="link2" name="link1" type="text" class="form-control" placeholder="link">
                <input type="text" id="chave_alterar" style="display:none" name="elemento_alterar">
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-success">Salvar</button>
        </div>
      </div>
    </div>
  </div>
 </form>

<form method="post" action="index.php">
  <div class="modal fade" id="delete" tabindex="-1" role="dialog" aria-labelledby="delete" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalCenterTitle">Deletar</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
           <input id="nome1" name="nome" type="text" style="margin-bottom: 3px;" class="form-control" placeholder="Nome">
           <input id="link1" name="link" type="text" class="form-control" placeholder="link">
           <input type="text" id="chave" style="display:none" name="elemento_excluir">
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
          <button type="submit" class="btn btn-success">Salvar</button>
        </div>
      </div>
    </div>
  </div>
</form>


  <script src="assets/js/jquery-3.3.1.slim.min.js"></script>
<script src="assets/js/popper.min.js" ></script>
<script src="assets/js/bootstrap.min.js"></script>
  </body>	
</html>
</html>

<?php   
 if(!empty($_POST['submit']) && $_POST['submit'] = "salvar"){
   
   if((!empty($_POST['grupo_inserir']) && !empty($_POST['elemento_inserir']) && !empty($_POST['link_inserir'])) ){
        
        setGrupoElemento($_POST['grupo_inserir'], $_POST['elemento_inserir'], $_POST['link_inserir']);
        
        echo("<meta http-equiv='refresh' content='0'>");
  
   }else{
     
     echo "<script> document.querySelector('div[role=".'"alert"'."]').style.display = ".'"block"'.";</script>";
   
   }
 }

if(isset($_POST['elemento_excluir'])){
   ExcluirGrupoElemento($_POST['elemento_excluir']);
   // echo $_POST['elemento_excluir'];
   echo("<meta http-equiv='refresh' content='0'>");
 }

if(isset($_POST['elemento_alterar']) && isset($_POST['nome1']) && isset($_POST['link1']) && isset($_POST['grupo']) ){
    alterarGrupoElementos($_POST['elemento_alterar'], $_POST['grupo'], $_POST['nome1'], $_POST['link1']);
    // echo $_POST['elemento_alterar'].$_POST['nome1'].$_POST['link1'].$_POST['grupo'];
  echo("<meta http-equiv='refresh' content='0'>");
}

?>