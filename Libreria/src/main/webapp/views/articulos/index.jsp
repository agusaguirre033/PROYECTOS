<%@ page language="java" contentType="text/html; charset=ISO-8859-1"
    pageEncoding="ISO-8859-1"%>
 <%@ taglib prefix = "c" uri = "http://java.sun.com/jsp/jstl/core" %>
<html>
<head>
    <title>Listado de Artículos</title>
</head>
<body>
    <h1>Hola <c:out value="${sessionScope.usuario.nombre}"/></h1>
    <h1>Inventario de Artículos</h1>
    <a href="articulos?accion=create">Añadir Nuevo Artículo</a>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Código</th>
            <th>Título</th>
            <th>Autor</th>
            <th>Año</th>
            <th>Editorial</th>
            <th>Categoria</th>
            <th>Precio</th>
            <th>Stock</th>
            <th>Acciones</th>
        </tr>
        <c:forEach var="articulo" items="${inventario}">
            <tr>
                <td>${articulo.id }</td>
                <td>${articulo.codigo }</td>
                <td>${articulo.titulo }</td>
                <td>${articulo.autor }</td>
                <td>${articulo.año }</td>
                <td>${articulo.editorial }</td>
                <td>${articulo.categoria }</td>
                <td>${articulo.precio }</td>
                <td>${articulo.stock }</td>
                
                <td>
                    <a href="articulos?accion=show&id=${articulo.id}">Ver</a> |
                    <a href="articulos?accion=edit&id=${articulo.id}">Editar</a> |
          
                </td>
            </tr>
        </c:forEach>
    </table>
</body>
</html>
