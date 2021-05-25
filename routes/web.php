<?php

/*
  |--------------------------------------------------------------------------
  | Web Routes
  |--------------------------------------------------------------------------
  |
  | Here is where you can register web routes for your application. These
  | routes are loaded by the RouteServiceProvider within a group which
  | contains the "web" middleware group. Now create something great!
  |
 */

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();
//cambiar contraseña
//Route::get('usuarios/contrasenia/cambiar', 'UsuarioController@vistacontrasenia')->name('usuario.vistacontrasenia');
//Route::post('usuarios/contrasenia/cambiar/finalizar', 'UsuarioController@cambiarcontrasenia')->name('usuario.cambiarcontrasenia');

Route::get('/home', 'HomeController@index')->name('home');


//GRUPO DE RUTAS PARA LOS MENUS
Route::group(['middleware' => ['auth'], 'prefix' => 'menu'], function () {
    Route::get('usuarios', 'MenuController@usuarios')->name('menu.usuarios');
    Route::get('admisiones', 'MenuController@admisiones')->name('menu.admisiones');
    Route::get('matricula', 'MenuController@matricula')->name('menu.matricula');
    Route::get('inscripcion', 'MenuController@inscripcion')->name('menu.inscripcion');
    Route::get('academico', 'MenuController@academico')->name('menu.academico');
    Route::get('documental', 'MenuController@documental')->name('menu.documental');
    Route::get('aulavirtual', 'MenuController@aulavirtual')->name('menu.aulavirtual');
    Route::get('hojadevidaestudiante/{estudiante_id}', 'MenuController@hojadevidaestudiante')->name('menu.hojadevidaestudiante');
    Route::get('grados', 'MenuController@grados')->name('menu.grados');
    Route::get('academico/docente', 'MenuController@academicodocente')->name('menu.academicodocente');
    Route::get('academico/estudiante', 'MenuController@academico_e_a')->name('menu.academicoestudiante');
    Route::get('academico/acudiente', 'MenuController@academicoacudiente')->name('menu.academicoacudiente');
    Route::get('academico/{estudiante}/menu', 'MenuController@menuacudiente')->name('menu.academicomenuacudiente');
    Route::get('reportes', 'MenuController@reportes')->name('menu.reportes');
});


//GRUPO DE RUTAS PARA LA ADMINISTRACIÓN DE USUARIOS
Route::group(['middleware' => ['auth'], 'prefix' => 'usuarios'], function () {
    //MODULOS
    Route::resource('modulo', 'ModuloController');
    //PAGINAS O ITEMS DE LOS MODULOS
    Route::resource('pagina', 'PaginaController');
    //GRUPOS DE USUARIOS
    Route::resource('grupousuario', 'GrupousuarioController');
    Route::get('grupousuario/{id}/delete', 'GrupousuarioController@destroy')->name('grupousuario.delete');
    Route::get('privilegios', 'GrupousuarioController@privilegios')->name('grupousuario.privilegios');
    Route::get('grupousuario/{id}/privilegios', 'GrupousuarioController@getPrivilegios');
    Route::post('grupousuario/privilegios', 'GrupousuarioController@setPrivilegios')->name('grupousuario.guardar');
    //USUARIOS
    Route::resource('usuario', 'UsuarioController');
    Route::get('usuario/{id}/delete', 'UsuarioController@destroy')->name('usuario.delete');
    Route::post('operaciones', 'UsuarioController@operaciones')->name('usuario.operaciones');
    Route::post('usuarios/contrasenia/cambiar/admin/finalizar', 'UsuarioController@cambiarPass')->name('usuario.cambiarPass');
    Route::post('acceso', 'HomeController@confirmaRol')->name('rol');
    Route::get('inicio', 'HomeController@inicio')->name('inicio');
    //USUARIOS AUTOMATICOS
    Route::get('automaticos/estudiantes/index', 'UsuarioController@automaticoEstudianteIndex')->name('usuariosautomaticos.estudiantesindex');
    Route::get('automaticos/docentes/index', 'UsuarioController@automaticoDocenteIndex')->name('usuariosautomaticos.docentesindex');
    Route::post('automaticos/store', 'UsuarioController@automaticostore')->name('usuariosautomaticos.store');
});


//GRUPO DE RUTAS PARA LOS PROCESOS DE ADMISIÓN Y SELECCIÓN
Route::group(['middleware' => ['auth'], 'prefix' => 'admisiones'], function () {
    //PAISES
    Route::resource('pais', 'PaisController');
    Route::get('pais/{id}/delete', 'PaisController@destroy')->name('pais.delete');
    Route::get('pais/{id}/estados', 'PaisController@estados')->name('pais.estados');
    //ESTADOS
    Route::resource('estado', 'EstadoController');
    Route::get('estado/{id}/delete', 'EstadoController@destroy')->name('estado.delete');
    Route::get('estado/{id}/ciudades', 'EstadoController@ciudades')->name('estado.ciudades');
    //CIUDADES
    Route::resource('ciudad', 'CiudadController');
    Route::get('ciudad/{id}/delete', 'CiudadController@destroy')->name('ciudad.delete');
    Route::get('ciudad/{id}/sectores', 'CiudadController@sectores')->name('ciudad.sectores');
    //TIPO DE DOCUMENTOS
    Route::resource('tipodoc', 'TipodocController');
    Route::get('tipodoc/{id}/delete', 'TipodocController@destroy')->name('tipodoc.delete');
    //SEXO
    Route::resource('sexo', 'SexoController');
    Route::get('sexo/{id}/delete', 'SexoController@destroy')->name('sexo.delete');
    //ENITDAD SALUD
    Route::resource('entidadsalud', 'EntidadsaludController');
    Route::get('entidadsalud/{id}/delete', 'EntidadsaludController@destroy')->name('entidadsalud.delete');
    //ETNIA
    Route::resource('etnia', 'EtniaController');
    Route::get('etnia/{id}/delete', 'EtniaController@destroy')->name('etnia.delete');
    //ESTRATO
    Route::resource('estrato', 'EstratoController');
    Route::get('estrato/{id}/delete', 'EstratoController@destroy')->name('estrato.delete');
    //OCUPACION LABORAL
    Route::resource('ocupacion', 'OcupacionController');
    Route::get('ocupacion/{id}/delete', 'OcupacionController@destroy')->name('ocupacion.delete');
    //PERIODO ACADEMICO
    Route::resource('periodoacademico', 'PeriodoacademicoController');
    Route::get('periodoacademico/{id}/delete', 'PeriodoacademicoController@destroy')->name('periodoacademico.delete');
    //GRADOS(AÑOS ESCOLARES)
    Route::resource('gradoacademico', 'GradoController');
    Route::get('gradoacademico/{id}/delete', 'GradoController@destroy')->name('gradoacademico.delete');
    //CON QUIEN VIVE
    Route::resource('conquienvive', 'ConquienviveController');
    Route::get('conquienvive/{id}/delete', 'ConquienviveController@destroy')->name('conquienvive.delete');
    //RANGO SISBEN
    Route::resource('rangosisben', 'RangosisbenController');
    Route::get('rangosisben/{id}/delete', 'RangosisbenController@destroy')->name('rangosisben.delete');
    //SITUACION AÑO ANTERIOR
    Route::resource('situacionanterior', 'SituacionanioanteriorController');
    Route::get('situacionanterior/{id}/delete', 'SituacionanioanteriorController@destroy')->name('situacionanterior.delete');
    //UNIDAD
    Route::resource('unidad', 'UnidadController');
    Route::get('unidad/{id}/delete', 'UnidadController@destroy')->name('unidad.delete');
    //JORNADA
    Route::resource('jornada', 'JornadaController');
    Route::get('jornada/{id}/delete', 'JornadaController@destroy')->name('jornada.delete');
    //PROGRAMAR PERIODO ACADEMICO
    Route::resource('periodounidad', 'PeriodounidadController');
    Route::get('periodounidad/{id}/delete', 'PeriodounidadController@destroy')->name('periodounidad.delete');
    //PROGRAMAR AGENDA DE ENTREVISTAS
    Route::resource('agendacita', 'AgendacitasController');
    Route::get('agendacita/{id}/delete', 'AgendacitasController@destroy')->name('agendacita.delete');
    Route::get('agendacita/{id}/crear', 'AgendacitasController@create')->name('agendacita.crear');
    //FECHAS DE PROCESOS
    Route::resource('fechaprocesos', 'FechasprocesosacademicoController');
    Route::get('fechaprocesos/{id}/index2', 'FechasprocesosacademicoController@index')->name('fechaprocesos.index2');
    Route::get('fechaprocesos/{per}/{proceso}/{jornada}/{unidad}/fechas', 'FechasprocesosacademicoController@listID')->name('fechaprocesos.fechas');
    Route::post('fechaprocesos/set', 'FechasprocesosacademicoController@set')->name('fechaprocesos.set');
    Route::get('fechaprocesos/{id}/delete', 'FechasprocesosacademicoController@destroy')->name('fechaprocesos.delete');
    //CONVOCATORIA
    Route::resource('convocatoria', 'ConvocatoriaController');
    Route::get('convocatoria/{id}/delete', 'ConvocatoriaController@destroy')->name('convocatoria.delete');
    //DOCUMENTOs ANEXOS
    Route::resource('documentosanexos', 'DocumentoanexoController');
    Route::get('documentosanexos/{id}/delete', 'DocumentoanexoController@destroy')->name('documentosanexos.delete');
    //PARAMETRIZAR DOCUMENTOS ANEXOS
    Route::resource('parametrizardocumentosanexos', 'ParametrizardocumentoanexoController');
    Route::get('parametrizardocumentosanexos/{id}/delete', 'ParametrizardocumentoanexoController@destroy')->name('parametrizardocumentosanexos.delete');
    Route::get('parametrizardocumentosanexos/{unidad}/{jornada}/{grado}/{proceso}/getdocparametrizados', 'ParametrizardocumentoanexoController@getParametrizados')->name('parametrizardocumentosanexos.getparametrizados');
    Route::get('parametrizardocumentosanexos/{unidad}/{jornada}/{grado}/{proceso}/{id}/guardarparametrizados', 'ParametrizardocumentoanexoController@storeParametrizados')->name('parametrizardocumentosanexos.guardarparametrizados');
    //VERIFICAR REQUISITOS
    Route::get('verificarrequisitos/index', 'VerificarrequisitosController@index')->name('verificarrequisitos.index');
    Route::get('verificarrequisitos/{unidad}/{periodo}/{jornada}/{grado}/listar', 'VerificarrequisitosController@listaraspirantes')->name('verificarrequisitos.listaraspirantes');
    Route::get('verificarrequisitos/{aspirante}/listarrequisitos', 'VerificarrequisitosController@listarrequisitos')->name('verificarrequisitos.listarrequisitos');
    Route::get('verificarrequisitos/listarrequisitos/{aspirante}/{documento}/{proceso}/check', 'VerificarrequisitosController@check')->name('verificarrequisitos.check');
    Route::get('verificarrequisitos/listarrequisitos/{requisito}/delete', 'VerificarrequisitosController@removeRequisito')->name('verificarrequisitos.removeRequisito');
    //CIRCUNSCRIPCIÓN
    Route::resource('circunscripcion', 'CircunscripcionController');
    Route::get('circunscripcion/{id}/delete', 'CircunscripcionController@destroy')->name('circunscripcion.delete');
    //CONTRTO DE INSCRIPCIÓN
    Route::resource('contratoinscripcion', 'ContratoinscripcionController');
    //ENTREVISTA DESDE ADMISIONES
    Route::get('entrevista/inicio', 'EntrevistaController@create')->name('entrevista.create');
    Route::get('entrevista/inicio/aspirantes/{unidad}/{periodo}/{jornada}/{grado}/listar', 'EntrevistaController@listaraspirantes')->name('entrevista.listaraspirantes');
    Route::get('entrevista/inicio/aspirantes/listar/{aspirante}/horas/disponibles', 'EntrevistaController@horas')->name('entrevista.horas');
    Route::get('entrevista/inicio/aspirantes/listar/{aspirante}/horas/disponibles/{cita}/agendar', 'EntrevistaController@agendarcita')->name('entrevista.agendarcita');
    //GESTIÓN DE CUESTIONARIOS DE ENTREVISTAS
    Route::resource('cuestionarioentrevista', 'CuestionarioentrevistaController');
    Route::get('cuestionarioentrevista/{id}/delete', 'CuestionarioentrevistaController@destroy')->name('cuestionarioentrevista.delete');
    Route::get('cuestionarioentrevista/{id}/continuar', 'CuestionarioentrevistaController@continuar')->name('cuestionarioentrevista.continuar');
    Route::get('cuestionarioentrevista/{id}/continuar/preguntacreate', 'CuestionarioentrevistaController@preguntacreate')->name('cuestionarioentrevista.preguntacreate');
    Route::post('cuestionarioentrevista/continuar/preguntastore', 'CuestionarioentrevistaController@preguntastore')->name('cuestionarioentrevista.preguntastore');
    Route::get('cuestionarioentrevista/{pregunta}/continuar/pregunta/delete', 'CuestionarioentrevistaController@preguntadelete')->name('cuestionarioentrevista.preguntadelete');
    Route::get('cuestionarioentrevista/{pregunta}/continuar/pregunta/continuar', 'CuestionarioentrevistaController@preguntacontinuar')->name('cuestionarioentrevista.preguntacontinuar');
    Route::get('cuestionarioentrevista/{pregunta}/continuar/pregunta/continuar/respuesta/create', 'CuestionarioentrevistaController@respuestacreate')->name('cuestionarioentrevista.respuestacreate');
    Route::post('cuestionarioentrevista/continuar/pregunta/continuar/respuesta/store', 'CuestionarioentrevistaController@respuestastore')->name('cuestionarioentrevista.respuestastore');
    Route::get('cuestionarioentrevista/continuar/pregunta/continuar/{respuesta}/respuesta/delete', 'CuestionarioentrevistaController@respuestadelete')->name('cuestionarioentrevista.respuestadelete');
    //ÁREAS EXÁMEN DE ADMISIÓN
    Route::resource('areaexamenadmision', 'AreaexamenadmisionController');
    Route::get('areaexamenadmision/{id}/delete', 'AreaexamenadmisionController@destroy')->name('areaexamenadmision.delete');
    //PARAMETRIZAR ÁREAS EXÁMEN DE ADMISIÓN
    Route::resource('areaexamenadmisiongrado', 'AreaexamenadmisiongradoController');
    Route::get('areaexamenadmisiongrado/{grado}/verificar/pesos', 'AreaexamenadmisiongradoController@pesos')->name('areaexamenadmisiongrado.pesos');
    Route::get('areaexamenadmisiongrado/{id}/delete', 'AreaexamenadmisiongradoController@destroy')->name('areaexamenadmisiongrado.delete');
    //EXAMEN ADMISION
    Route::resource('examenadmision', 'ExamenadmisionController');
    Route::get('examenadmision/inicio/aspirantes/{unidad}/{periodo}/{jornada}/{grado}/listar', 'ExamenadmisionController@listaraspirantes')->name('examenadmision.listaraspirantes');
    Route::get('examenadmision/inicio/aspirantes/{aspirante}/examen', 'ExamenadmisionController@examen')->name('examenadmision.examen');
    //REALIZAR ENTREVISTA
    Route::resource('realizarentrevista', 'RealizarentrevistaController');
    Route::get('realizarentrevista/inicio/aspirantes/{unidad}/{periodo}/{jornada}/{grado}/listar', 'RealizarentrevistaController@listaraspirantes')->name('realizarentrevista.listaraspirantes');
    Route::get('realizarentrevista/inicio/aspirantes/{id}/{origen}/cargarcuestionario', 'RealizarentrevistaController@cargarcuestionario')->name('realizarentrevista.cargarcuestionario');
    Route::get('realizarentrevista/inicio/aspirantes/{aspirante}/{entrevista}/{cuestionario}/cargarcuestionario/asignarcuestionario', 'RealizarentrevistaController@asignarcuestionario')->name('realizarentrevista.asignarcuestionario');
    //ADMITIR ASPIRANTES
    Route::resource('admitiraspirantes', 'AdmitiraspirantesController');
    Route::get('admitiraspirantes/inicio/aspirantes/{unidad}/{periodo}/{jornada}/{grado}/listar', 'AdmitiraspirantesController@listaraspirantes')->name('admitiraspirantes.listaraspirantes');
    Route::get('admitiraspirantes/{id}/{estado}/procesar/estado', 'AdmitiraspirantesController@admitir')->name('admitiraspirantes.admitir');
});

//GRUPO DE RUTAS PARA LA ADMINISTRACIÓN DE MATRÍCULA
Route::group(['middleware' => ['auth'], 'prefix' => 'matricula'], function () {
    //CICLOS
    Route::resource('ciclo', 'CicloController');
    Route::get('ciclo/{id}/delete', 'CicloController@destroy')->name('ciclo.delete');
    Route::get('ciclo/area/{id}/delete', 'CicloController@destroyArea')->name('ciclo.deleteArea');
    Route::get('ciclo/area/{id_area}/{id_ciclo}/agregar', 'CicloController@agregarArea')->name('ciclo.agregarArea');
    Route::get('ciclo/{id}/grados', 'CicloController@grados')->name('ciclo.grados');
    Route::get('ciclo/grados/{id}/delete', 'CicloController@destroyGrado')->name('ciclo.deleteGrado');
    Route::get('ciclo/grados/{id_grado}/{id_ciclo}/agregar', 'CicloController@agregarGrado')->name('ciclo.agregarGrado');
    //ÁREAS
    Route::resource('area', 'AreaController');
    Route::get('area/{id}/delete', 'AreaController@destroy')->name('area.delete');
    //CATEGORÍA ESTUDIANTE
    Route::resource('categoria', 'CategoriaController');
    Route::get('categoria/{id}/delete', 'CategoriaController@destroy')->name('categoria.delete'); //CATEGORÍA ESTUDIANTE
    //SITUACION ESTUDIANTE
    Route::resource('situacionestudiante', 'SituacionestudianteController');
    Route::get('situacionestudiante/{id}/delete', 'SituacionestudianteController@destroy')->name('situacionestudiante.delete'); //CATEGORÍA ESTUDIANTE
    //NATURALEZA DE LAS MATERIAS
    Route::resource('naturaleza', 'NaturalezaController');
    Route::get('naturaleza/{id}/delete', 'NaturalezaController@destroy')->name('naturaleza.delete');
    //MATERIAS
    Route::resource('materia', 'MateriaController');
    Route::get('materia/{id}/delete', 'MateriaController@destroy')->name('materia.delete');
    Route::get('materias/{id}/materia', 'MateriaController@materia')->name('materias.materia'); //agregado por johnp
    //ITEM CONTENIDO MATERIA
    Route::resource('itemcontenidomateria', 'ItemcontenidomateriaController');
    Route::get('itemcontenidomateria/{id}/delete', 'ItemcontenidomateriaController@destroy')->name('itemcontenidomateria.delete');
    //CONTENIDOS DE ITEM DE MATERIA
    Route::resource('contenidoitem', 'ContenidoitemController');
    Route::get('contenidoitem/{id}/delete', 'ContenidoitemtController@destroy')->name('contenidoitem.delete');
    //VERIFICAR REQUISITOS PARA MATRICULA, AVALA Y FORMALIZA LA MATRICULA
    Route::get('verificarrequisitos/matricula/index', 'VerificarrequisitosController@indexmatricula')->name('verificarrequisitos.indexmatricula');
    Route::get('verificarrequisitos/matricula/{unidad}/{periodo}/{jornada}/{grado}/listar', 'VerificarrequisitosController@listaraspirantesmatricula')->name('verificarrequisitos.listaraspirantesmatricula');
    Route::get('verificarrequisitos/matricula/{aspirante}/listarrequisitos', 'VerificarrequisitosController@listarrequisitosmatricula')->name('verificarrequisitos.listarrequisitosmatricula');
    Route::get('verificarrequisitos/matricula/listarrequisitos/{aspirante}/{documento}/{proceso}/check', 'VerificarrequisitosController@checkmatricula')->name('verificarrequisitos.checkmatricula');
    Route::get('verificarrequisitos/matricula/listarrequisitos/{requisito}/delete', 'VerificarrequisitosController@removeRequisitomatricula')->name('verificarrequisitos.removeRequisitomatricula');
    Route::get('verificarrequisitos/matricula/verificarpago/{aspirante}/pagar', 'VerificarrequisitosController@pagar')->name('verificarrequisitos.pagar');
    //CONVERTIR ASPIRANTES EN ESTUDIANTES
    Route::get('convertiraspirantes/index', 'ConvertiraspirantesController@index')->name('convertiraspirantes.index');
    Route::get('convertiraspirantes/{unidad}/{periodo}/{jornada}/{grado}/{situacionestudiante}/{rol}/{categoria}/convertir', 'ConvertiraspirantesController@convertiraspirantes')->name('convertiraspirantes.convertiraspirantes');
    //GRUPOS, CURSOS PARA LOS GRADOS
    Route::resource('grupo', 'GrupoController');
    Route::get('grupo/{id}/delete', 'GrupoController@destroy')->name('grupo.delete');
    Route::get('grupo/{unidad}/{periodo}/{jornada}/{grado}/continuar', 'GrupoController@continuar')->name('grupo.continuar');
    Route::get('grupo/{grupo}/{docente}/asignar/director', 'GrupoController@asignardirector')->name('grupo.asignardirector');
    //MATRICULAR ESTUDIANTES NUEVOS
    Route::resource('matricularnuevos', 'MatricularnuevosController');
    Route::get('matricularnuevos/{id}/delete', 'MatricularnuevosController@destroy')->name('matricularnuevos.delete');
    Route::get('matricularnuevos/{unidad}/{periodo}/{jornada}/{grado}/continuar', 'MatricularnuevosController@continuar')->name('matricularnuevos.continuar');
    //MATRICULAR ESTUDIANTES ANTIGUOS
    Route::resource('matricularantiguos', 'MatricularantiguosController');
    Route::get('matricularantiguos/matriculados/{grupo}/listar', 'MatricularantiguosController@matriculados')->name('matricularantiguos.matriculados');
    Route::get('matricularantiguos/nomatriculados/{unidad}/{periodo}/{jornada}/{grado}/{situacion}/{estado}/listar', 'MatricularantiguosController@nomatriculados')->name('matricularantiguos.nomatriculados');
    Route::get('matricularantiguos/matricula/estudiantes/antiguos/{grupo}/{estudiante}/matricular', 'MatricularantiguosController@matriculara')->name('matricularantiguos.matriculara');
    Route::get('matricularantiguos/matricula/estudiantes/antiguos/{estudiantegrupo}/retirara', 'MatricularantiguosController@retirara')->name('matricularantiguos.retirara');
    Route::get('matricularantiguos/matricula/estudiantes/antiguos/{unidad}/{periodo}/{jornada}/{grado}/listar/matriculados', 'MatricularantiguosController@estmatriculados')->name('matricularantiguos.estmatriculados');
    Route::get('matricularantiguos/matricula/estudiantes/antiguos/{estudiantegrupo}/{nuevogrupo}/matriculados/grupo/cambiar', 'MatricularantiguosController@cambiar')->name('matricularantiguos.cambiar');
});


//GRUPO DE RUTAS PARA LA ADMINISTRACIÓN DE ACADÉMICO
Route::group(['middleware' => ['auth'], 'prefix' => 'academico'], function () {
    //CARGA ACADÉMICA GRADOS
    Route::resource('cargagrados', 'CargagradoController');
    Route::get('cargagrados/{id}/delete', 'CargagradoController@destroy')->name('cargagrados.delete');
    Route::get('cargagrados/{unidad}/{periodo}/{jornada}/{grado}/continuar', 'CargagradoController@continuar')->name('cargagrados.continuar');
    Route::get('cargagrados/{unidad}/{periodo}/{jornada}/{grado}/{materia}/{peso}/agregar', 'CargagradoController@agregar')->name('cargagrados.agregar');
    //CARGA ACADÉMICA GRUPOS DOCENTE MATERIA
    Route::resource('cargagrupomatdoc', 'CargagrupomatdocController');
    Route::get('cargagrupomatdoc/{id}/delete', 'CargagrupomatdocController@destroy')->name('cargagrupomatdoc.delete');
    Route::get('cargagrupomatdoc/{unidad}/{periodo}/{jornada}/{grado}/grupos', 'CargagrupomatdocController@grupos')->name('cargagrupomatdoc.grupos');
    Route::get('cargagrupomatdoc/{unidad}/{periodo}/{jornada}/{grado}/{grupo}/continuar', 'CargagrupomatdocController@continuar')->name('cargagrupomatdoc.continuar');
    Route::get('cargagrupomatdoc/{gradomateria}/{grupo}/agregar', 'CargagrupomatdocController@agregar')->name('cargagrupomatdoc.agregar');
    Route::get('cargagrupomatdoc/{grupomateriadocente}/{docente}/docente', 'CargagrupomatdocController@docente')->name('cargagrupomatdoc.docente');
    //SITUACION ADMINISTRATIVA
    Route::resource('situacionadministrativa', 'SituacionadministrativaController');
    Route::get('situacionadministrativa/{id}/delete', 'SituacionadministrativaController@destroy')->name('situacionadministrativa.delete');
    Route::post('situacionadministrativa/actualizar/enviar', 'SituacionadministrativaController@actualizar')->name('situacionadministrativa.actualizar');
    //MATRICULA FINANCIERA
    Route::resource('matriculafinanciera', 'MatriculafinancieraController');
    //DOCENTES
    Route::resource('docente', 'DocenteController');
    Route::get('docente/{persona}/{clave}/{valor}/buscar', 'DocenteController@busqueda');
    Route::get('docente/{personanatural}/{situacion}/agregar', 'DocenteController@docente');
    Route::get('docente/{docente}/{situacion}/situacion/cambiar', 'DocenteController@cambiarSituacion');
    //PERSONA NATURAL
    Route::resource('personanatural', 'PersonanaturalController');
    Route::post('personanatural/actualizar/enviar', 'PersonanaturalController@actualizar')->name('personanatural.actualizar');
    Route::get('personanatural/{id}/personaNaturals', 'PersonanaturalController@personaNatural2')->name('personanatural.personaNaturals');
    //ESTUDIANTE
    Route::resource('estudiante', 'EstudianteController');
    Route::get('estudiante/{id}/getestudiante', 'EstudianteController@getEstudiante')->name('estudiante.getEstudiante');
    //HOJA DE VIDA ESTUDIANTE
    Route::resource('hojadevida', 'HojadevidaestudianteController');
    //datos basicos y complementarios
    Route::get('hojadevida/datospersonales/{estudiante}', 'HojadevidaestudianteController@modestudiante')->name('hojadevida.datosbasicos');
    Route::post('hojadevida/modificar/datospersonales', 'HojadevidaestudianteController@modificardatosbasicos')->name('hojadevida.moddatosbasicos');
    Route::get('hojadevida/datoscomplementarios/{estudiante}', 'HojadevidaestudianteController@moddatoscomplementarios')->name('hojadevida.complementarios');
    Route::post('hojadevida/modificar/datos/complementarios', 'HojadevidaestudianteController@modcomplementarios')->name('hojadevida.modcomplementarios');
    //PADRES DEL ESTUDINATE
    Route::resource('padresestudiante', 'PadresestudianteController');
    Route::get('padresestudiantes/padres/{estudiante}/listar', 'PadresestudianteController@inicio')->name('padresestudiante.inicio');
    Route::get('padresestudiantes/crear/{estudiante}', 'PadresestudianteController@crear')->name('padresestudiante.crear');
    Route::get('padresestudiantes/{estudiante}/destroy', 'PadresestudianteController@destroy')->name('padresestudiante.delete');
    //RESPONSABLE FINANCIERO ESTUDIANTE
    Route::resource('responsablefestudiante', 'ResponsablefestudianteController');
    Route::get('responsablefestudiante/{estudiante}/listar', 'ResponsablefestudianteController@inicio')->name('responsablefestudiante.inicio');
    Route::get('responsablefestudiante/crear/{estudiante}', 'ResponsablefestudianteController@crear')->name('responsablefestudiante.crear');
    Route::get('responsablefestudiante/{estudiante}/destroy', 'ResponsablefestudianteController@destroy')->name('responsablefestudiante.delete');
    //ACUDIENTES
    Route::resource('acudientes', 'AcudienteController');
    Route::get('acudientes/inicio/{estudiante_id}', 'AcudienteController@index')->name('acudientes.inicio');
    Route::get('acudientes/estudiante/{estudiante_id}/crear', 'AcudienteController@create')->name('acudientes.crear');
    Route::get('acudientes/{personanatural_id}/{estudiante_id}/agregar', 'AcudienteController@agregar')->name('acudientes.agregar');
    Route::get('acudientes/{estudiante_id}/destroy', 'AcudienteController@destroy')->name('acudientes.delete');
    //HORARIO
    Route::resource('horario', 'HorarioController');
    Route::get('horario/destroy/{id}', 'HorarioController@destroy')->name('horario.delete');
    //SANCIONES Y DISCIPLINAS
    Route::resource('sancion', 'SancionController');
    Route::get('sancion/destroy/{id}', 'SancionController@destroy')->name('sancion.delete');
    Route::get('sancion/{id}/crear', 'SancionController@create')->name('sancion.crear');
    //SISTEMA DE EVALUACION
    Route::resource('sistemaevaluacion', 'SistemaevaluacionController');
    Route::get('sistemaevaluacion/destroy/{id}', 'SistemaevaluacionController@destroy')->name('sistemaevaluacion.delete');
    //EVALUACION ACADEMICA
    Route::resource('evaluacionacademica', 'EvaluacionController');
    //REQUISITOS DE GRADO
    Route::resource('requisitogrado', 'RequisitogradoController');
    Route::get('requisitogrado/destroy/{id}', 'RequisitogradoController@destroy')->name('requisitogrado.delete');
    //ASIGNAR REQUISITO GRADO
    Route::resource('asignarrequisitogrado', 'AsignarrequisitogradoController');
    Route::get('asignarrequisitogrado/{unidad_id}/{jornada_id}/{grado_id}/getrequisitos', 'AsignarrequisitogradoController@getRequisito')->name('asignarrequisitogrado.getrequisito');
    Route::get('asignarrequisitogrado/{unidad_id}/{jornada_id}/{grado_id}/{requisito_id}/agregarrequisito', 'AsignarrequisitogradoController@agregar')->name('asignarrequisitogrado.agregarrequisito');
    Route::get('asignarrequisitogrado/{id}/eliminar', 'AsignarrequisitogradoController@destroy')->name('asignarrequisitogrado.destroy');
    //CEREMONIA
    Route::resource('ceremonia', 'CeremoniaController');
    Route::get('ceremonia/destroy/{id}', 'CeremoniaController@destroy')->name('ceremonia.delete');
    //VERIFICAR REUQISITOS GRADO
    Route::resource('verificarrequisitogrado', 'VerificarrequisitogradoController');
    Route::get('verificarrequisitogrado/{unidad_id}/{periodoacademico_id}/{jornada_id}/{grado_id}/listar', 'VerificarrequisitogradoController@listarEstudiantes')->name('verificarrequisitogrado.listar');
    Route::get('verificarrequisitogrado/{estudiante_id}/{periodo}/{jornada}/{unidad}/{grado}/verificar', 'VerificarrequisitogradoController@listarRequisitos')->name('verificarrequisitogrado.listarrequisitos');
    Route::get('verificarrequisitogrado/{estudiante}/{asignarrequisitogrado}/{periodo}/{jornada}/{unidad}/{grado}', 'VerificarrequisitogradoController@check')->name('verificarrequisitogrado.check');
    Route::get('verificarrequisitogrado/remover/{asignarrequisito}/{periodo}/{jornada}/{unidad}/{grado}/requisito', 'VerificarrequisitogradoController@removeRequisito')->name('verificarrequisitogrado.removeRequisito');
    //ASIGNAR ESTUDIANTES A CEREMONIA
    Route::resource('ceremoniaestudiante', 'CeremoniaestudianteController');
    Route::get('ceremoniaestudiante/{undidad}/{peridodo}/{jornada}/{grado}/getCeremonia', 'CeremoniaestudianteController@getCeremonia')->name('ceremoniaestudiante.getCeremonia');
    Route::get('ceremoniaestudiante/{unidad}/{periodo}/{jornada}/{grado}/{ceremonia}/listar', 'CeremoniaestudianteController@listarestudiantes')->name('ceremoniaestudiante.listar');
    Route::get('ceremoniaestudiante/{estudiante}/{ceremonia}/agregar', 'CeremoniaestudianteController@agregar')->name('ceremoniaestudiante.agregar');
    Route::get('ceremoniaestudiante/{id}/retirar', 'CeremoniaestudianteController@retirar')->name('ceremoniaestudiante.retirar');
    //GRADUAR ESTUDIANTES
    Route::resource('graduarestudiante', 'GraduarestudianteController');
    Route::get('graduarestudiante/{ceremonia}/listar', 'GraduarestudianteController@show')->name('graduarestudiante.listar');
});

//GRUPO DE RUTAS PARA EL PANEL DEL ACUDIENTE
Route::group(['middleware' => ['auth'], 'prefix' => 'acudiente'], function () {
    //INSCRIPCION DE ACUDIENTE
    Route::get('inscripcion/acudiente', 'InscripcionController@index')->name('inscripcion.index');
    //INSCRIPCION DE ASPIRANTES
    Route::post('inscripcion/acudiente/guardar', 'InscripcionController@store')->name('inscripcion.store');
    Route::get('inscripcion/aspirante/inscribir', 'InscripcionController@aspirante')->name('inscripcion.aspirante');
    Route::get('inscripcion/aspirante/inscribir/{unidad}/{grado}/{periodo}/{jornada}/{tipodoc}/{documento}/inicio', 'InscripcionController@aspiranteform')->name('inscripcion.aspiranteform');
    Route::post('inscripcion/aspirante/inscribir/inicio/store', 'InscripcionController@aspirantestore')->name('inscripcion.aspirantestore');
    Route::get('inscripcion/aspirante/listar', 'AspiranteController@index')->name('aspirante.lista');
    Route::get('inscripcion/aspirante/listar/{id}/menu', 'AspiranteController@menu')->name('aspirante.menu');
    Route::get('inscripcion/aspirante/listar/{id}/menu/aspirante', 'AspiranteController@modaspirante')->name('aspirante.modaspirante');
    Route::post('inscripcion/aspirante/listar/menu/aspirante/modificar', 'AspiranteController@modificardp')->name('aspirante.modificardp');
    Route::get('inscripcion/aspirante/listar/{id}/menu/complementarios', 'AspiranteController@modcomplementarios')->name('aspirante.modcomplementarios');
    Route::post('inscripcion/aspirante/listar/menu/aspirante/modificar/complementarios', 'AspiranteController@modificarcomp')->name('aspirante.modificarcomp');
    //IMPRIMIR FORMULARIO DE INSCRIPCION
    Route::get('inscripcion/aspirante/listar/formularios/inscripcion', 'InscripcionController@formimprimir')->name('inscripcion.formimprimir');
    Route::get('inscripcion/aspirante/listar/formularios/inscripcion/{id}/imprimir', 'InscripcionController@formimprimirpdf')->name('inscripcion.formimprimirpdf');
    //REQUISITOS DE INSCRIPCION
    Route::get('inscripcion/aspirantes/documentosanexos', 'InscripcionController@documentosanexos')->name('inscripcion.documentosanexos');
    Route::get('inscripcion/aspirantes/documentosanexos/{unidad}/{grado}/{jornada}/ver', 'InscripcionController@documentosanexosver')->name('inscripcion.documentosanexosver');
    //PADRES DE LOS ASPIRANTES
    Route::resource('padresaspirantes', 'PadresaspiranteController');
    Route::get('padresaspirantes/{id}/lista', 'PadresaspiranteController@lista')->name('padresaspirantes.lista');
    Route::get('padresaspirantes/lista/{id}/delete', 'PadresaspiranteController@destroy')->name('padresaspirantes.delete');
    Route::get('padresaspirantes/{id}/lista/create', 'PadresaspiranteController@create')->name('padresaspirantes.crear');
    //RESPONSABLE FINANCIERO DEL ASPIRANTES
    Route::resource('responsablefaspirante', 'ResponsablefinancieroaspiranteController');
    Route::get('responsablefaspirante/lista/{id}/delete', 'ResponsablefinancieroaspiranteController@destroy')->name('responsablefaspirante.delete');
    //ENTREVISTA DESDE EL ACUDIENTE
    Route::resource('entrevistaa', 'EntrevistaController');
    Route::get('entrevistaa/cita/{aspirante}/{cita}/agendar', 'EntrevistaController@agendar')->name('entrevistaa.agendar');
    //CARGA ACADEMICA
    Route::get('cargaacademica/acudiente/{estudiante}', 'CargaacademicaController@acudiente')->name('cargaacademica.acudiente');
    //CALIFICACIONES
    Route::get('calificaciones/academico/acudiente/{estudiante}', 'CalificacionestudianteController@todasacudiente')->name('calificaciones.todasacudiente');
    //HORARIO
    Route::get('horario/academico/{estudiante}/acudiente', 'HorarioController@horarioacudiente')->name('horario.horarioacudiente');
});

//GRUPO DE RUTAS PARA EL PANEL DEL AULA VIRTUAL
Route::group(['middleware' => ['auth'], 'prefix' => 'aulavirtual'], function () {
    //INICIO DOCENTE
    Route::get('docente/inicio', 'IniciovirtualdocenteController@iniciodocente')->name('aulavirtual.docenteinicio');
    Route::get('docente/inicio/{unidad}/{periodo}/{jornada}/grados', 'IniciovirtualdocenteController@gradosdocente');
    Route::get('docente/inicio/{unidad}/{periodo}/{jornada}/{grado}/materias', 'IniciovirtualdocenteController@materiasdocente');
    Route::get('docente/inicio/{unidad}/{periodo}/{jornada}/{grado}/grupos/delgrado', 'IniciovirtualdocenteController@gruposgrado');
    Route::get('docente/inicio/{gmd_id}/menu/aula/docente', 'IniciovirtualdocenteController@menuauladocente')->name('aulavirtual.menuauladocente');
    Route::get('docente/inicio/estudiantes/{grupomatdoc_id}/imprimir', 'IniciovirtualdocenteController@imprimirlista')->name('aulavirtual.imprimir');
    //FORO DE DISCUSION
    Route::get('forodiscusion/docente/{gmd}/inicio', 'ForodiscusionController@iniciodocente')->name('forodiscusion.docenteinicio');
    Route::get('forodiscusion/docente/{gmd}/inicio/crear', 'ForodiscusionController@create')->name('forodiscusion.create');
    Route::post('forodiscusion/docente/inicio/guardar', 'ForodiscusionController@store')->name('forodiscusion.store');
    Route::get('forodiscusion/docente/inicio/foro/{id}/leer', 'ForodiscusionController@leerforo')->name('forodiscusion.leerforo');
    Route::post('forodiscusion/docente/inicio/guardar/respuesta/foro', 'ForodiscusionController@storerespuesta')->name('forodiscusion.storerespuesta');
    //FORO DE DISCUSION ESTUDIANTE
    Route::get('forodiscusion/estudiante/{gmd}/inicio', 'ForodiscusionController@inicioestudiante')->name('forodiscusion.estudianteinicio');
    Route::get('forodiscusion/estudiante/{gmd}/inicio/crear', 'ForodiscusionController@createe')->name('forodiscusion.createe');
    Route::post('forodiscusion/estudiante/inicio/guardar/foro', 'ForodiscusionController@storeforo')->name('forodiscusion.storeforo');
    Route::get('forodiscusion/estudiante/inicio/foro/{id}/leer', 'ForodiscusionController@leerforoe')->name('forodiscusion.leerforoe');
    Route::post('forodiscusion/estudiante/inicio/guardar/respuesta/foro', 'ForodiscusionController@storerespuestae')->name('forodiscusion.storerespuestae');
    //BANCO DE ACTIVIDADES
    Route::get('actividad/{gmd}/inicio', 'ActividadController@index')->name('actividad.index');
    Route::get('actividad/{gmd}/inicio/crear', 'ActividadController@crear')->name('actividad.crear');
    Route::post('actividad/inicio/crear/store', 'ActividadController@store')->name('actividad.store');
    Route::get('actividad/{gmd}/inicio/{id}/ver', 'ActividadController@show')->name('actividad.show');
    Route::get('actividad/{gmd}/inicio/{id}/editar', 'ActividadController@edit')->name('actividad.edit');
    Route::get('actividad/{gmd}/inicio/{id}/continuar', 'ActividadController@continuar')->name('actividad.continuar');
    Route::post('actividad/inicio/crear/update', 'ActividadController@update')->name('actividad.update');
    //EBEDUC
    Route::get('ebeduc/{gmd}/inicio', 'EbeducController@index')->name('ebeduc.index');
    Route::get('ebeduc/{gmd}/inicio/crear', 'EbeducController@crear')->name('ebeduc.crear');
    Route::post('ebeduc/inicio/crear/store', 'EbeducController@store')->name('ebeduc.store');
    Route::get('ebeduc/{gmd}/inicio/{id}/ver', 'EbeducController@show')->name('ebeduc.show');
    Route::get('ebeduc/{gmd}/inicio/{id}/editar', 'EbeducController@edit')->name('ebeduc.edit');
    Route::get('ebeduc/{gmd}/inicio/{id}/continuar', 'EbeducController@continuar')->name('ebeduc.continuar');
    Route::post('ebeduc/inicio/crear/update', 'EbeducController@update')->name('ebeduc.update');
    //BANCO DE PREGUNTAS
    Route::get('preguntas/{gmd}/inicio', 'PreguntaController@index')->name('preguntas.index');
    Route::get('preguntas/{gmd}/inicio/crear', 'PreguntaController@crear')->name('preguntas.crear');
    Route::post('preguntas/inicio/crear/store', 'PreguntaController@store')->name('preguntas.store');
    Route::get('preguntas/{gmd}/inicio/{id}/ver', 'PreguntaController@show')->name('preguntas.show');
    Route::get('preguntas/{gmd}/inicio/{id}/editar', 'PreguntaController@edit')->name('preguntas.edit');
    Route::post('preguntas/inicio/update', 'PreguntaController@update')->name('preguntas.update');
    Route::get('preguntas/{gmd}/inicio/{id}/continuar', 'PreguntaController@continuar')->name('preguntas.continuar');
    Route::post('preguntas/inicio/crear/respuesta/store', 'PreguntaController@storerespuesta')->name('preguntas.storerespuesta');
    Route::post('preguntas/inicio/crear/respuesta/editrespuesta', 'PreguntaController@editrespuesta')->name('preguntas.editrespuesta');
    Route::get('preguntas/{gmd}/inicio/crear/respuesta/{respuesta_id}/deleterespuesta', 'PreguntaController@deleterespuesta')->name('preguntas.deleterespuesta');
    Route::get('preguntas/{gmd}/inicio/crear/respuesta/{respuesta_id}/correctarespuesta', 'PreguntaController@correctarespuesta')->name('preguntas.correctarespuesta');
    //PREGUNTAS ACTIVIDAD
    Route::get('actividad/{gmd}/inicio/{actividad_id}/continuar/preguntas/{pregunta}', 'ActividadController@addpregunta')->name('actividad.addpregunta');
    Route::get('actividad/{gmd}/inicio/{ap_id}/continuar/preguntas/ya/delete', 'ActividadController@deletepregunta')->name('actividad.deletepregunta');
    //PREGUNTAS EBEDUC
    Route::get('ebeduc/{gmd}/inicio/{ebeduc_id}/continuar/preguntas/{pregunta}', 'EbeducController@addpregunta')->name('ebeduc.addpregunta');
    Route::get('ebeduc/{gmd}/inicio/{ap_id}/continuar/preguntas/ya/delete', 'EbeducController@deletepregunta')->name('ebeduc.deletepregunta');
    //ACTIVIDADES, EXAMENES & EBEDUC: ASIGNACIÓN
    Route::get('asignaractividad/{gmd}/index', 'AsignaractividadController@index')->name('asignaractividad.index');
    Route::get('asignaractividad/{gmd}/{evaluacion}/asignar', 'AsignaractividadController@asignar')->name('asignaractividad.asignar');
    Route::post('asignaractividad/asignar/store', 'AsignaractividadController@asignarstore')->name('asignaractividad.asignarstore');
    Route::get('asignarebeduc/{gmd}/{evaluacion}/asignar/ebeduc', 'AsignaractividadController@asignarebeduc')->name('asignarebeduc.asignar');
    Route::post('asignarebeduc/asignar/store/ebeduc', 'AsignaractividadController@asignarebeducstore')->name('asignarebeduc.asignarstore');
    //INICIO ESTUDIANTE
    Route::get('estudiante/inicio', 'IniciovirtualestudianteController@inicioestudiante')->name('aulavirtual.estudianteinicio');
    Route::get('estudiante/inicio/{unidad}/{periodo}/{jornada}/{grado}/materias/estudiante', 'IniciovirtualestudianteController@materiasestudiante');
    Route::get('estudiante/inicio/{gmd_id}/menu/aula/estudiante', 'IniciovirtualestudianteController@menuaulaestudiante')->name('aulavirtual.menuaulaestudiante');
    //ACTIVIDADES, EXAMENES & EBEDUC: REALIZACIÓN
    Route::get('realizaractividad/{gmd}/index', 'RealizaractividadController@index')->name('realizaractividad.index');
    Route::get('realizaractividad/{gmd}/index/{actividad}/ver', 'RealizaractividadController@ver')->name('realizaractividad.ver');
    Route::get('realizaractividad/{gmd}/index/{actividad}/realizar/actividad', 'RealizaractividadController@realizar')->name('realizaractividad.realizar');
    Route::post('realizaractividad/index/realizar/actividad/guardar/subirresultado', 'RealizaractividadController@subirresultado')->name('realizaractividad.subirresultado');
    Route::post('realizaractividad/index/realizar/actividad/guardar/subirresultado/pedircalificacion', 'RealizaractividadController@pedircalificacion')->name('realizaractividad.pedircalificacion');
    Route::post('realizaractividad/index/realizar/actividad/guardar/examen/ebeduc/guardarexamen', 'RealizaractividadController@guardarexamen')->name('realizaractividad.guardarexamen');
    //CALIFICACIONES DOCENTE
    Route::get('calificacion/docente/{gmd}/index', 'CalificaciondocenteController@index')->name('calificaciondocente.index');
    Route::get('calificacion/docente/{gmd}/actividad/{actividad}/calificar', 'CalificaciondocenteController@listarestudiantes')->name('calificaciondocente.listarestudiantes');
    Route::get('calificacion/docente/{gmd}/actividad/{actividad}/calificar/{estudiante}/vistacalificar', 'CalificaciondocenteController@vistacalificar')->name('calificaciondocente.vistacalificar');
    Route::post('calificacion/docente/actividad/calificar/vistacalificar/calificarcero', 'CalificaciondocenteController@calificarcero')->name('calificaciondocente.calificarcero');
    Route::post('calificacion/docente/actividad/calificar/vistacalificar/calificar/actividad', 'CalificaciondocenteController@calificaractividad')->name('calificaciondocente.calificaractividad');
    Route::post('calificacion/docente/actividad/calificar/vistacalificar/calificar/actividad/observaciones', 'CalificaciondocenteController@observaciones')->name('calificaciondocente.observaciones');
    Route::post('calificacion/docente/actividad/calificar/vistacalificar/calificar/actividad/solo/calificacion', 'CalificaciondocenteController@solocalificacion')->name('calificaciondocente.solocalificacion');
    //CALIFICACIONES ESTUDIANTE
    Route::get('calificacion/estudiante/{gmd}/index', 'CalificacionestudianteController@index')->name('calificacionestudiante.index');
    //CONTENIDO TEMATICO ESTUDIANTE
    Route::get('contenido/tematico/estudiante/{gmd}/index', 'ContenidotematicoController@contenido_estudiante')->name('contenidotematico.estudiante');
    Route::get('contenido/tematico/estudiante/{gmd}/temas/{unidad}/listar', 'ContenidotematicoController@contenido_estudianteTemas')->name('contenidotematico.estudiante_temas');
});

//GRUPO DE RUTAS PARA EL PANEL DEL ESTUDIANTE
Route::group(['middleware' => ['auth'], 'prefix' => 'estudiante'], function () {
    //CARGA ACADEMICA
    Route::get('cargaacademica/estudiante', 'CargaacademicaController@estudiante')->name('cargaacademica.estudiante');
    //CALIFICACIONES
    Route::get('calificaciones/academico/estudiante', 'CalificacionestudianteController@todasestudiante')->name('calificaciones.todasestudiante');
    //HORARIO
    Route::get('horario/academico/estudiante', 'HorarioController@horarioestudiante')->name('horario.horarioestudiante');
});

//GRUPO DE RUTAS PARA EL PANEL DEL DOCENTE
Route::group(['middleware' => ['auth'], 'prefix' => 'docente'], function () {
    //CARGA ACADEMICA
    Route::get('cargaacademica/docente', 'CargaacademicaController@docente')->name('cargaacademica.docente');
    Route::get('cargaacademica/getcarga/{unidad}/{periodo}/{jornada}/materias', 'CargaacademicaController@getCarga')->name('cargaacademica.getcarga');
    //CONTENIDO TEMÁTICO
    Route::get('cargaacademica/docente/contenido', 'ContenidotematicoController@index')->name('cargaacademica.contenido');
    Route::get('cargaacademica/docente/contenido/{grado}/{materia}/gestionar', 'ContenidotematicoController@gestionar_contenido')->name('cargaacademica.gestionar_contenido');
    Route::get('cargaacademica/docente/contenido/{grado}/{materia}/malla_curricular', 'ContenidotematicoController@malla_curricular')->name('cargaacademica.malla_curricular');
    Route::post('cargaacademica/docente/contenido/malla_curricular/asignar/unidad', 'ContenidotematicoController@malla_asignarunidad')->name('cargaacademica.malla_asignarunidad');
    Route::get('cargaacademica/docente/contenido/{grado}/{materia}/malla_curricular/eliminar/{unidadevaluacion_id}/unidad', 'ContenidotematicoController@malla_eliminarunidad')->name('cargaacademica.malla_eliminarunidad');
    Route::post('cargaacademica/docente/contenido/gestionar/store', 'ContenidotematicoController@store')->name('contenido.store');
    Route::get('cargaacademica/docente/contenido/{grado}/{materia}/gestionar/{unidad}/configurar', 'ContenidotematicoController@configurar')->name('contenido.configurar');
    Route::post('cargaacademica/docente/contenido/gestionar/update', 'ContenidotematicoController@update')->name('contenido.actualizar');
    Route::get('cargaacademica/docente/contenido/gestionar/{unidad}/estandar/{estandar}/agregar', 'ContenidotematicoController@addEstandar')->name('contenido.addEstandar');
    Route::get('cargaacademica/docente/contenido/{grado}/{materia}/gestionar/{unidad}/estandar/{estandar}/eliminar', 'ContenidotematicoController@deleteEstandar')->name('contenido.deleteEstandar');
    Route::get('cargaacademica/docente/contenido/{grado}/{materia}/gestionar/{unidad}/estandar/{estandar}/componentes', 'ContenidotematicoController@componentesEstandar')->name('contenido.componentesEstandar');
    Route::get('cargaacademica/docente/contenido/{grado}/{materia}/gestionar/{unidad}/estandar/{estandar}/componentes/{aprendizaje_id}/addAprendizaje', 'ContenidotematicoController@addAprendizajeEstandar')->name('contenido.addAprendizajeEstandar');
    Route::get('cargaacademica/docente/contenido/{grado}/{materia}/gestionar/{unidad}/estandar/{estandar}/componentes/{ctunidadestandaraprendizaje_id}/delete/aprendizaje', 'ContenidotematicoController@deleteAprendizajeEstandar')->name('contenido.deleteAprendizajeEstandar');
    Route::post('cargaacademica/docente/contenido/gestionar/tema/store', 'ContenidotematicoController@temaStore')->name('contenido.temaStore');
    Route::get('cargaacademica/docente/contenido/{grado}/{materia}/gestionar/{unidad}/tema/{tema}/configurar', 'ContenidotematicoController@temaConfigurar')->name('contenido.temaConfigurar');
    Route::post('cargaacademica/docente/contenido/gestionar/tema/configurar/actualizar', 'ContenidotematicoController@temaActualizar')->name('contenido.temaActualizar');
    Route::post('cargaacademica/docente/contenido/gestionar/tema/configurar/subtema/crear', 'ContenidotematicoController@subtema_crear')->name('contenido.subtema_crear');
    Route::post('cargaacademica/docente/contenido/gestionar/tema/configurar/subtema/actualizar', 'ContenidotematicoController@subtema_actualizar')->name('contenido.subtema_actualizar');
    Route::get('cargaacademica/docente/contenido/gestionar/tema/{tema}/configurar/subtema/{subtema}}/eliminar', 'ContenidotematicoController@subtema_eliminar')->name('contenido.subtema_eliminar');
});

Route::group(['middleware' => ['auth'], 'prefix' => 'documental'], function () {
    //COMPONENTES
    Route::resource('componente', 'ComponenteController');
    Route::get('componente/{id}/delete', 'ComponenteController@destroy')->name('componente.delete');
    //COMPETENCIAS
    Route::resource('competencia', 'CompetenciaController');
    Route::get('competencia/{id}/delete', 'CompetenciaController@destroy')->name('competencia.delete');
    //COMPETENCIA A COMPONENTES
    Route::get('componente/competencias/index', 'ComponenteController@competencias')->name('componente.competencias');
    Route::get('componente/competencias/{componente_id}/{competencia_id}/agregar', 'ComponenteController@addcompetencias')->name('componente.addcompetencias');
    Route::get('componente/competencias/{id}/eliminar', 'ComponenteController@deletecompetencias')->name('componente.deletecompetencias');
    //ESTANDAR
    Route::resource('estandar', 'EstandarController');
    Route::get('estandar/{id}/{area}/{grupo}/delete', 'EstandarController@destroy')->name('estandar.delete');
    Route::get('estandar/{area}/{grupo}/listar', 'EstandarController@listar')->name('estandar.listar');
    Route::post('estandar/actualizar', 'EstandarController@actualizar')->name('estandar.actualizar');
    Route::get('estandar/{estandar}/{grupo}/configurar', 'EstandarController@configurar')->name('estandar.configurar');
    Route::get('estandar/{estandar}/{grupo}/configurar/{componente}/addComponente', 'EstandarController@addComponente')->name('estandar.addComponente');
    Route::get('estandar/{estandar}/{grupo}/configurar/{componente_competencia}/removeComponente', 'EstandarController@removeComponente')->name('estandar.removeComponente');
    Route::post('estandar/configurar/logro/adicionar/', 'EstandarController@addLogro')->name('estandar.addLogro');
    Route::get('estandar/{estandar}/{grupo}/configurar/{logro}/remover/logro', 'EstandarController@removeLogro')->name('estandar.removeLogro');
    Route::post('estandar/configurar/logro/adicionar/indicador', 'EstandarController@addIndicador')->name('estandar.addIndicador');
    Route::get('estandar/{estandar}/{grupo}/configurar/logro/remover/{indicador}/indicador', 'EstandarController@removeIndicador')->name('estandar.removeIndicador');
    //LOGROS
    Route::resource('logro', 'LogroController');
    Route::get('logro/inicio/{gmd}/listar', 'LogroController@listar')->name('logro.listar');
    Route::get('logro/{grupomateria}/{gmd}/crear', 'LogroController@create')->name('logro.crear');
    Route::get('logro/editar/{grupomateria}/{gmd}/editar', 'LogroController@edit')->name('logro.editar');
    //ASIGNAR LOGROS A GRADOS
    Route::get('logro/asignar/logro/{logro_id}/{gmd}/{per}/guardar', 'LogroController@asignar')->name('logro.asignar');
    Route::get('logro/retirar/{algm}/{gmd}/logro', 'LogroController@retirar')->name('logro.retirar');
    //PERSONALIZAR LOGROS ESTUDIANTE
    Route::get('logro/personalizar/inicio', 'LogroController@personalizar_inicio')->name('logro.personalizar_inicio');
    Route::get('logro/personalizar/inicio/{gmd}/estudiantes', 'IniciovirtualdocenteController@estudiantes')->name('logro.estudiantes');
    Route::get('logro/personalizar/inicio/{gmd}/estudiantes/delgrupo', 'IniciovirtualdocenteController@estudiantesdelgrupo')->name('logro.estudiantesdelgrupo');
    Route::get('logro/personalizar/inicio/{gmd}/{estudiante}/revisar/logros', 'LogroController@revisarlogros')->name('logro.revisarlogros');
    Route::post('logro/personalizar/inicio/revisar/logros/guardar/logro/personalizado', 'LogroController@guardarlp')->name('logro.guardarlp');
    Route::get('logro/personalizar/inicio/{gmd}/{estudiante}/revisar/logros/retirar/logro/{logro}/personalizado', 'LogroController@retirarlp')->name('logro.retirarlp');
    //BOLETINES
    Route::resource('boletines', 'BoletinController');
    Route::get('boletines/{grupo}/{periodo}/{evaluacion}/procesar', 'BoletinController@procesar')->name('boletines.procesar');
});

//REPORTES
Route::group(['middleware'=> ['auth'],'prefix'=>'reportes'],function(){
    Route::get('listadogeneraldocentes/imprimir/{imprimir?}/{exportar?}','DocenteController@listadoGeneralDocente')->name('reportes.listadogeneraldocentes');
    Route::get('cargadocente','ReportesController@ViewCargaDocente')->name('reportes.cargadocente');
    Route::get('cargadocente/{unidad_id}/{periodoacademico_id}/{exportar}/imprimir/','DocenteController@cargaDocente')->name('reportes.cargadocenteimprimir');
    Route::get('cargadocente/{unidad_id}/{periodoacademico_id}/{docente_id}/{exportar}/imprimir/','DocenteController@getCargaDocente')->name('reportes.getcargadocenteimprimir');
});
