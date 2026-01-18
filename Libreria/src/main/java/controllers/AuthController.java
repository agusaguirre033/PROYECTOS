package controllers;


import java.io.IOException;

import javax.servlet.ServletException;
import javax.servlet.annotation.WebServlet;
import javax.servlet.http.HttpServlet;
import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpServletResponse;
import javax.servlet.http.HttpSession;


import models.Usuario;
import repositories.UsuariosRepoSingleton;



@WebServlet("/auth")
public class AuthController extends HttpServlet {
	private static final long serialVersionUID = 1L;

	private UsuariosRepoSingleton usuariosRepo;

	public AuthController() throws IOException {
        this.usuariosRepo = UsuariosRepoSingleton.getInstance();
    }

	protected void doGet(HttpServletRequest request, HttpServletResponse response)
			throws ServletException, IOException {



		request.getRequestDispatcher("/views/auth/login.jsp").forward(request, response);

	}
	



	protected void doPost(HttpServletRequest request, HttpServletResponse response)
			throws ServletException, IOException {

		String nombre = request.getParameter("nombre");
        String password = request.getParameter("password");


        Usuario usuario = usuariosRepo.getUsuario(nombre);

        if (usuario != null && usuario.getPassword().equals(password)) {
           
            HttpSession session = request.getSession();
            session.setAttribute("usuario", usuario);

            if (usuario.getRol().equals("Empleado")) {
                
                response.sendRedirect("views/articulos/index.jsp");
            } else {
               
                response.sendRedirect("views/carrito/index.jsp");
            }
        } else {
       
            request.setAttribute("error", "Nombre de usuario o contraseña incorrectos");
            request.getRequestDispatcher("/views/auth/login.jsp").forward(request, response);
        }

	}

}




