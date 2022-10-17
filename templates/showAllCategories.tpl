{include file="templates/header.tpl"}
    <div class="bloqueContenido">
        <div class="listado">
            <h2>Listado de Categorias</h2>
            <table>
                <thead>
                    <th>Categorías</th>
                    <th {if $isAdmin}colspan="3"{/if}>Acciones</th>
                </thead>
                <tbody>
                    {foreach from=$categories item=$category} 
                    <tr>
                        <td><span>{$category->categoria}</span></td>
                        <td><span><a class="botonTabla" href="category/detail/{$category->id}">Ver productos</a></span></td>
                        {if $isAdmin}
                        <td><a class="botonTabla" href="category/edit/{$category->id}">Editar</a></td>
                        <td><a class="botonTabla" href="category/delete/{$category->id}">Eliminar</a></td>
                        {/if}
                    </tr>
                    {/foreach}
                </tbody>
            </table>
        </div>
    </div>
{include file="templates/footer.tpl"}
