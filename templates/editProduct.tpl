{include file='templates/header.tpl'}
    <div class="bloqueContenido">
        <div class="listado">
            <h2>Modificando el producto {$product->nombre}</h2>
            <p>En el formulario se muestran los datos actuales. Puede modificar los que crea necesario</p>
            <form enctype="multipart/form-data" action="product/update/{$product->id}" method="post">
                <label for="nombre">Nombre del producto: </label>
                <input class="campoFormulario" type="text" name="nombre" value="{$product->nombre}"></input>
                <label for="descripcion">Descripción: </label>
                <input class="campoFormulario" type="textarea" name="descripcion" value="{$product->descripcion}"></input>
                <label for="imagen">Seleccione un archivo de tipo imagen (.JPEG/.JPG/.PNG/.GIF): </label>
                <input class="campoFormulario" type="file" name="imagen"></input>
                
                <label for="precio">Precio: </label>
                <input class="campoFormulario" type="number" step="any" name="precio" value="{$product->precio}"></input>
                <label for="categoria">Categoría: </label>
                <select class="campoFormulario" name="id_categoria">
                    {foreach from=$categories item=$category}
                        {if $category->id == $product->id_categoria}
                            <option selected value={$category->id}>{$category->categoria}</option>
                        {else}
                            <option value={$category->id}>{$category->categoria}</option>
                        {/if}
                    {/foreach}
                </select>
                <input type="hidden" name="imagenAnterior" value="{$product->imagen}">
                <input class="botonFormulario" type="submit" value="Editar Producto">
            </form>
        </div>
    </div>
{include file='templates/footer.tpl'}

