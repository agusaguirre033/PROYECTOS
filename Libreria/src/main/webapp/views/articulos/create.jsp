<%@ page language="java" contentType="text/html; charset=ISO-8859-1"
    pageEncoding="ISO-8859-1"%>
   
<!DOCTYPE html>
<html>
<head>
<meta charset="ISO-8859-1">
<title>Mostrar Datos del Libro</title>
</head>


<body>

<h1>Alta artículo</h1>

<form action="articulos" method="post">
<input type="hidden" value = "insert" name ="accion">

<p>
Codigo:<input value= "" name="codigo"/>
</p>
<p>
Titulo:<input value= "" name="titulo"/>
</p>
<p>
Autor:<input value= "" name="autor"/>
</p>
<p>
Año:<input value= "0" name="año"/>
</p>
<p>
Editorial:<input value= "" name="editorial"/>
</p>
<p>
Categoria:<input value= "" name="categoria"/>
</p>
<p>
Precio:<input value= "0" name="precio"/>
</p>
<p>
Stock:<input value= "0" name="stock"/>
</p>

<input type="submit" value="Registrar"/>
</form>
</body>
</html>