<%@ page language="java" contentType="text/html; charset=ISO-8859-1"
    pageEncoding="ISO-8859-1"%>
<!DOCTYPE html>
<html>
<head>
<meta charset="ISO-8859-1">
<title>Editar</title>
</head>
<body>
<h1>Editar</h1>

<form action="articulos" method="post">
<input type="hidden" value = "update" name ="accion">
<input type="hidden" value = "${articulo.id}" name ="id">

<p>
Codigo:<input value= "${articulo.codigo}" name="codigo"/>
</p>
<p>
Titulo:<input value= "${articulo.titulo}" name="titulo"/>
</p>
<p>
Autor:<input value= "${articulo.autor}" name="autor"/>
</p>
<p>
Año:<input value= "${articulo.año}" name="año"/>
</p>
<p>
Editorial:<input value= "${articulo.editorial}" name="editorial"/>
</p>
<p>
Categoria:<input value= "${articulo.categoria}" name="categoria"/>
</p>
<p>
Precio:<input value= "${articulo.precio}" name="precio"/>
</p>
<p>
Stock:<input value= "${articulo.stock}" name="stock"/>
</p>

<input type="submit" value="Editar"/>
</form>

</body>
</html>