{include file="templates/header.tpl"}
    <div class="bloqueContenido">
        <div class="listado">
            <h2>Alta de nueva categoría</h2>
            <form action="category/insert" method="post">
                <label for="category">Nombre de la nueva categoria: </label>
                <input class="campoFormulario" type="text" name="category" placeholder="Ingrese el nombre de la nueva categoría"></input>
                <select class="campoFormulario" name="segment">
                    <option disabled selected>Seleccione un segmento</option>
                    <option value="Bronce">Bronce</option>
                    <option value="Plata">Plata</option>
                    <option value="Oro">Oro</option>
                </select>
                <input class="botonFormulario" type="submit" value="Agregar Categoria">
            </form>
        </div>        
    </div>
{include file="templates/footer.tpl"}