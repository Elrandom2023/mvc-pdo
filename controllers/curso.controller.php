<?php

require_once '../models/Curso.php';

if (isset($_POST['operacion'])){

  $curso = new Curso();

  if ($_POST['operacion'] == 'listar'){

    $datosObtenidos = $curso->listarCursos();
    
    // En esta ocacion NO enviaremos un objeto JSON, en su lugar
    // el controlador renderizara las filas que necesita <tbody></tbody>
    // echo json_encode($datosObtenidos);


    //  PASO 1: Verificar que el objeto contenga datos
    if ($datosObtenidos){
      $numeroFila = 1;
      // Paso 2: Recorrer todo el objeto
      foreach($datosObtenidos as $curso){
        // PASO 3: Ahora construiremos las filas
        echo "
          <tr>
            <td>{$numeroFila}</td>
            <td>{$curso['nombrecurso']}</td>
            <td>{$curso['especialidad']}</td>
            <td>{$curso['complejidad']}</td>
            <td>{$curso['fechainicio']}</td>
            <td>{$curso['precio']}</td>
            <td>
              <a href='#' data-idcurso='{$curso['idcurso']}' class='btn btn-danger btn-sm eliminar'><i class='bi bi-trash3'></i></a>
              <a href='#' data-idcurso='{$curso['idcurso']}' class='btn btn-warning btn-sm editar'><i class='bi bi-pencil-square'></i></a>
            </td>
         
          </tr>
        ";
        $numeroFila++;
      }
    }
  }

  if ($_POST['operacion']  == 'registrar'){

    // PASO 1: Recoger los datos que nos envia la vista (FORM, utilizando AJAX)
    // $_POST: Esto es lo que se nos envia desde FORM
    $datosForm = [
      "nombrecurso"   => $_POST['nombrecurso'],
      "especialidad"  => $_POST['especialidad'],
      "complejidad"   => $_POST['complejidad'],
      "fechainicio"   => $_POST['fechainicio'],
      "precio"        => $_POST['precio']
    ];

    // PASO 2: Enviar el arreglo como parametro del metodo registrar
    $curso->registrarCurso($datosForm);

  }

  if ($_POST['operacion'] == 'eliminar'){
    $curso->eliminarCurso($_POST['idcurso']);
  }
  if ($_POST['operacion'] == 'obtenercurso'){
    $registro = $curso->getCurso($_POST['idcurso']);
    echo json_encode($registro);
  }

  if ($_POST['operacion'] == 'actualizar'){
        // PASO 1: Recoger los datos que nos envia la vista (FORM, utilizando AJAX)
        $datosForm = [
          "idcurso"       => $_POST['idcurso'],
          "nombrecurso"   => $_POST['nombrecurso'],
          "especialidad"  => $_POST['especialidad'],
          "complejidad"   => $_POST['complejidad'],
          "fechainicio"   => $_POST['fechainicio'],
          "precio"        => $_POST['precio']
        ];
    
        // PASO 2: Enviar el arreglo como parametro del metodo ACTUALIZAR
        $curso->actualizarCurso($datosForm);
    
  }
}
