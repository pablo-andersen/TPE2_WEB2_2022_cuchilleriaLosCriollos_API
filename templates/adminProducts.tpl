{include file="templates/header.tpl"}
    <div class="bloqueContenido">
        <div class="listado">
            <h2>Alta de nuevo Producto</h2>
            <p>Para ingresar un nuevo producto debe completar todos los campos, adjuntando una imagen y seleccionar la categoría a la cual pertenece desde el desplegable (campos requeridos).</p>
            <form enctype="multipart/form-data" action="product/insert" method="post">
                <input class="campoFormulario" type="text" name="nombre" placeholder="Nombre del nuevo producto:"></input>
                <input class="campoFormulario" type="textarea" name="descripcion" placeholder="Ingrese una breve reseña..."></input>
                <label for="imagen">Seleccione un archivo de tipo imagen (.JPEG/.JPG/.PNG/.GIF): </label>
                <input class="campoFormulario" type="file" name="imagen"></input>
                <input class="campoFormulario" type="number" step="any" name="precio" placeholder="Precio del nuevo producto"></input>
                <select class="campoFormulario" name="id_categoria">
                    <option disabled selected>Seleccione una categoria</option>
                    {foreach from=$categories item=$category}
                        <option value={$category->id}>{$category->categoria}</option>
                    {/foreach}

                </select>
                <input class="botonFormulario" type="submit" value="Agregar Producto">
            </form>
        </div>
    </div>
{include file="templates/footer.tpl"}



