<%@ page language="java" contentType="text/html; charset=ISO-8859-1"
    pageEncoding="ISO-8859-1"%>
    <%@ taglib prefix = "c" uri = "http://java.sun.com/jsp/jstl/core" %>
<!DOCTYPE html>
<html>
<head>
<meta charset="ISO-8859-1">
<title>Mostrar Artículo</title>
</head>
<body>
  <h1>Artículo</h1>
 <p>
     Código:
     <c:out value="${articulo.codigo}"/>
 </p>
 <p>
     Título:
   <c:out value="${articulo.titulo}"/>
 </p>
 <p>
     Autor:
     <c:out value="${articulo.autor}"/>
 </p>
 <p>
     Año:
     <c:out value="${articulo.año}"/>
 </p>
 <p>
     Editorial:
     <c:out value="${articulo.editorial}"/>
 </p>
 <p>
     Categoria:
     <c:out value="${articulo.categoria}"/>
 </p>
 <p>
     Precio:
     <c:out value="${articulo.precio}"/>
 </p>
 <p>
     Stock:
     <c:out value="${articulo.stock}"/>
 </p>
  
  <form action = "articulos" method="post">
     <input type="hidden" name="id" value="${articulo.id}">
     <input type="hidden" name= "accion" value="delete">
     <input type="submit" value="Eliminar artículo">
    
  </form>
</body>
</html>