{include file='templates/header.tpl'}
    <div class="bloqueContenido">
        <div class="listado">
            <h2>Detalle del producto: {$product->nombre}</h2>
            <table>
                <thead>
                    <th>Nombre</th>
                    <th>Descripcion</th>
                    <th>Imagen</th>
                    <th>Precio</th>
                    <th>Categoria</th>
                    {if $isAdmin}
                        <th colspan="2">Acciones</th>
                    {/if}
                </thead>
                <tbody>
                    <tr>
                        <td>{$product->nombre}</td>
                        <td>{$product->descripcion}</td>
                        <td><img class="thumbnail" src="{$product->imagen}"></td>
                        <td>{$product->precio}</td>
                        <td>{$product->categoria}</td>
                        {if $isAdmin}
                            <td><a class="botonTabla" href="product/edit/{$product->id}">Editar</a></td>
                            <td><a class="botonTabla" href="product/delete/{$product->id}">Eliminar</a></td>
                        {/if}
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
{include file='templates/footer.tpl'}