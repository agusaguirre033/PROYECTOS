<%@ page language="java" contentType="text/html; charset=ISO-8859-1"
    pageEncoding="ISO-8859-1"%>
    <%@ taglib prefix = "c" uri = "http://java.sun.com/jsp/jstl/core" %>
<!DOCTYPE html>
<html>
<head>
    <title>Gestión de Artículos - Empleados</title>
    <style>
        body {
            font-family: sans-serif;
        }

        table {
            width: 80%;
            margin: 20px auto;
            border-collapse: collapse;
        }

        th, td {
            padding: 10px;
            text-align: left;
            border: 1px solid #ddd;
        }

        th {
            background-color: #f2f2f2;
        }

        form {
            width: 80%;
            margin: 20px auto;
        }

        label {
            display: block;
            margin-bottom: 5px;
        }

        input[type="text"], input[type="number"] {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
        }

        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            cursor: pointer;
        }
    </style>
</head>
<body>

    <h1>Gestión de Artículos</h1>

  
    
        <label for="codigo">Código:</label>
        <input type="number" id="codigo" name="codigo" required><br><br>

        <label for="titulo">Titulo:</label>
        <input type="text" id="titulo" name="titulo" required><br><br>
        
         <label for="autor">Autor:</label>
        <input type="text" id="autor" name="autor" required><br><br>

        <label for="precio">Precio:</label>
        <input type="number" id="precio" name="precio" step="0.01" required><br><br>

        <label for="stock">Stock:</label>
        <input type="number" id="stock" name="stock" required><br><br>

        <input type="submit" value="Agregar Artículo">
    

 
    <table>
        <thead>
            <tr>
                <th>Código</th>
                <th>Titulo</th>
                <th>Autor</th>
                <th>Precio</th>
                <th>Stock</th>
            </tr>
        </thead>
        <tbody>
           
           
    </table>

</body>
</html>