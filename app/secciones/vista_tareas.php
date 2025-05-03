<?php include('../template/cabecera.php'); ?>
<?php include('../secciones/tareas.php'); ?>


<div class="row">
    <div class="col-12">

        <div class="row">
            <div class="col-md-5">

                <form action="" method="post">
                    <div class="card">
                        <div class="card-header bg-dark text-white">Tareas</div>
                        <div class="card-body bg-dark text-white">
                            <input type="hidden" name="id" id="id" value="<?php echo $id; ?>">
                            <div class="mb-3 ">
                                <label for="titulo" class="form-label">Titulo</label>
                                <input
                                    type="text"
                                    class="form-control"
                                    name="titulo"
                                    id="titulo"
                                    value="<?php echo $titulo; ?>"
                                    aria-describedby="helpId"
                                    placeholder="Nombre de la tarea">
                            </div>

                            <div class="mb-3">
                                <label for="descripcion" class="form-label">Descripción</label>
                                <textarea
                                    class="form-control"
                                    name="descripcion"
                                    id="descripcion"
                                    rows="4"
                                    placeholder="Descripción de la tarea"><?php echo htmlspecialchars($descripcion); ?></textarea>
                            </div>



                            <div class="mb-3">
    <label for="estado" class="form-label">Estado</label>
    <select class="form-select" name="estado" id="estado" aria-describedby="helpId">
        <option value="Pendiente" <?php if ($estado == 'Pendiente') echo 'selected'; ?>>Pendiente</option>
        <option value="Realizado" <?php if ($estado == 'Realizado') echo 'selected'; ?>>Realizado</option>
    </select>
</div>


                            <div class="mb-3">
                                <label for="fecha" class="form-label">Fecha Limite</label>
                                <input
                                    type="date"
                                    class="form-control"
                                    name="fecha"
                                    id="fecha"
                                    value="<?php echo $fecha; ?>"
                                    aria-describedby="helpId"
                                    placeholder="Fecha Limite">
                            </div>

                            <div class="btn-group" role="group" aria-label="">
                                <button type="submit" name="accion" value="agregar" class="btn btn-dark">Agregar</button>
                                <button type="submit" name="accion" value="editar" class="btn btn-dark">Editar</button>
                                <button type="submit" name="accion" value="eliminar" class="btn btn-dark">Eliminar</button>
                            </div>
                        </div>
                    </div>
                </form>

            </div>
            <div class="col-md-7">
                <div class="table-responsive">
                <table class="table table-dark table-striped table-hover table-bordered align-middle">                        <thead>
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">Titulo</th>
                                <th scope="col">Descripcion</th> 
                                <th scope="col">Estado</th>
                                <th scope="col">Fecha de Entrega</th>
                                <th scope="col">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>


                            <?php $i = 1; ?>
                            <?php foreach ($listaTareas as $tarea) { ?>

                                <tr>
                                    <td><?php echo $i++; ?></td>
                                    <td><?php echo $tarea['titulo']; ?></td>
                                    <td><?php echo $tarea['descripcion']; ?></td>

                                    <td>
    <span class="badge 
        <?php 
            echo ($tarea['estado'] == 'Pendiente') ? 'bg-danger' : 'bg-success';
        ?>">
        <?php echo $tarea['estado']; ?>
    </span>
</td>




                                    <td><?php echo $tarea['fecha_limite']; ?></td>
                                    <td>
                                        <form action="" method="post">
                                            <input type="hidden" name="id" id="id" value="<?php echo $tarea['id']; ?>">
                                            <input type="submit" value="Seleccionar" name="accion" class="btn btn-dark">
                                        </form>
                                    </td>


                                </tr>
                            <?php } ?>

                        </tbody>
                    </table>
                </div>


            </div>
        </div>
    </div>
</div>

<?php include('../template/pie.php'); ?>