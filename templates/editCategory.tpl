{include file='templates/header.tpl'}
    <div class="bloqueContenido">
        <div class="listado">
            <h2>Modificando la categoría {$category->id}</h2>
            <form action="category/update/{$category->id}" method="post">
                <label for="category">Nombre de la nueva categoria: </label>
                <input class="campoFormulario" type="text" name="category" value="{$category->categoria}">
                <select class="campoFormulario" name="segment">
                    <option disabled selected>Seleccione un segmento</option>
                    <option value="Bronce">Bronce</option>
                    <option value="Plata">Plata</option>
                    <option value="Oro">Oro</option>
                </select>
                <input class="botonFormulario" type="submit" value="Confirmar">
            </form>
        </div>
    </div>
{include file='templates/footer.tpl'}


