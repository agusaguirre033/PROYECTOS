package decorators;

import java.io.IOException;
import java.util.NoSuchElementException;
import java.util.Optional;

import javax.servlet.http.HttpSession;

import exceptions.UsuarioDeslogueadoException;
import models.Usuario;
import repositories.interfaces.UsuarioRepo;
import utils.Carrito;

public class SessionDecorator {

	public static final String USUARIO = "usuario";
	public static final String CARRITO = "carrito";

	private HttpSession session;

	public SessionDecorator(HttpSession session) {
		this.session = session;
	}

	public HttpSession getSession() {
		return session;
	}

	public Carrito getProyecto() {

		Carrito proyecto = (Carrito) session.getAttribute(CARRITO);

		try {
			proyecto = Optional.ofNullable(proyecto).orElseThrow();
		} catch (NoSuchElementException e) {
			proyecto = new Carrito();
			session.setAttribute("carrito", proyecto);
		}

		return proyecto;
	}

	public Usuario getUsuarioLogueadoActu(UsuarioRepo repo) throws UsuarioDeslogueadoException, IOException {
		Usuario usuarioLog = this.getUsuarioLogueado();

		usuarioLog = repo.findById(usuarioLog.getId());

		session.setAttribute(USUARIO, usuarioLog);

		return usuarioLog;

	}

	public Usuario getUsuarioLogueado() throws UsuarioDeslogueadoException {
		Usuario usuarioLogNullable = (Usuario) session.getAttribute(USUARIO);

		Usuario usuarioLog = Optional.ofNullable(usuarioLogNullable)
				.orElseThrow(() -> new UsuarioDeslogueadoException());

		return usuarioLog;

	}

	public void setUsuarioLogueado(Usuario usuario) {
		session.setAttribute(USUARIO, usuario);
	}

	public void removeProyecto() {

		session.removeAttribute(CARRITO);

	}

}
