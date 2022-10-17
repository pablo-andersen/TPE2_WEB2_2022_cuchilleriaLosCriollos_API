<!DOCTYPE html>
<html lang="en">
<head>
    <base href="{BASE_URL}">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="templates/css/estilos.css">
    <title>Los Criollos - Cuchilleria Artesanal</title>
</head>
<body>
    <div class="container">
        <header>            
            {if $isAdmin}
                <div class="loggedUser"><span>Usuario logueado como: {$smarty.session.email}</span></div>
            {/if}
            <nav>
                <div class="logo">
                    <img src="templates/img/logo.png" id="logo" alt="logo de Los Criollos" />
                </div>
                <ul class="itemMenuMobile">    
                    <li><a href="home" class="linkMenu"><span  class="material-icons span.size-16">&#xe88a;</span>Home</a></li>
                    <li><a href="category/list" class="linkMenu"><span  class="material-icons span.size-16">&#xefa7;</span>Categorias</a></li>
                    <li><a href="product/list" class="linkMenu"><span  class="material-icons span.size-16">&#xf1cc;</span>Nuestros Productos</a></li>
                    {if $isAdmin}
                        <li><a href="logout" class="linkMenu"><span  class="material-icons span.size-16">&#xe9ba;</span>Logout</a></li>
                    {else}
                        <li><a href="login" class="linkMenu"><span  class="material-icons span.size-16">&#xea77;</span>Login</a></li>
                    {/if}
                    {if $isAdmin}
                        <ul class="itemMenuMobile">    
                            <li id="home"><a href="product/add" class="linkMenu"><span  class="material-icons span.size-16">&#xe147;</span>Agregar producto</a></li>
                            <li id="home"><a href="category/add" class="linkMenu"><span  class="material-icons span.size-16">&#xe147;</span>Agregar categoría</a></li>
                        </ul>
                    {/if}                    
                </ul>
            </nav>            
        </header>
