{include file='templates/header.tpl'}
    <div class="bloqueContenido">
        <div class="listado">
            <h2>Productos dentro de la categoría</h2>
            <table>
            <thead>
                <th>Producto</th>
                <th>Descripcion</th>
                <th {if $isAdmin}colspan="3"{/if}>Acciones</th>
            </thead>
            <tbody>
                {foreach from=$productsByCategory item=$product}
                <tr>
                    <td>{$product->nombre}</td>
                    <td>{$product->descripcion|truncate:45}</td>
                    <td><a class="botonTabla" href="product/detail/{$product->id}">Ver detalle</a></td>
                    {if $isAdmin}
                    <td><a class="botonTabla" href="product/edit/{$product->id}">Editar</a></td>
                    <td><a class="botonTabla" href="product/delete/{$product->id}">Eliminar</a></td>
                    {/if}
                </tr>
                {/foreach}
            </tbody>
        </table>
        </div>
    </div>
{include file='templates/footer.tpl'}
