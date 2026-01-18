package repositories.interfaces;

import java.io.IOException;
import java.util.List;

import models.Usuario;

public interface UsuarioRepo {
	
	public List<Usuario> getAll() throws IOException;
	
	public Usuario findById(int id) throws IOException;
	
	public void add (Usuario usuario) throws IOException;
	
	public void agregarUsuario(Usuario usuario) throws IOException;
	
	public Usuario getUsuario(String nombre) throws IOException;

}
