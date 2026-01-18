package repositories;


import java.io.IOException;
import java.util.ArrayList;
//import java.util.HashMap;
import java.util.List;
//import java.util.Map;


import models.Usuario;
import repositories.interfaces.UsuarioRepo;


public class UsuariosRepoSingleton implements UsuarioRepo {
	
	private static UsuariosRepoSingleton singleton;
//	private Map<String, String> usuarios;

	public static UsuariosRepoSingleton getInstance() throws IOException {
		if (singleton == null) {
			singleton = new UsuariosRepoSingleton();
		}
		return singleton;
	}

	private List<Usuario> listaUsuarios;
	
	private UsuariosRepoSingleton() throws IOException {
		
		this.listaUsuarios = new ArrayList<Usuario>();

		Usuario usuario1 = new Usuario ("Maria", "123456", "Empleado", 123.56);
		Usuario usuario2 = new Usuario ("Marta", "456789", "Cliente", 200);
		this.add(usuario1);
		this.add(usuario2);

//	     //oRepo?   
//	        usuarios = new HashMap<>();
//	        usuarios.put("Maria", "123456"); 
//	        usuarios.put("Diego", "876543");
	    }


	@Override
	public List<Usuario> getAll() throws IOException {
		return listaUsuarios.stream().toList();
	}


	@Override
	public Usuario findById(int id) throws IOException {
		return this.listaUsuarios.stream()
		.filter((a)-> a.getId() == id ) // filtramos
		.findAny()
		.orElse(null);
	}

    public void add(Usuario usu) {
		
		this.listaUsuarios.add(usu);
	}
    
    
	
	
	public void agregarUsuario(Usuario usuario) {
        listaUsuarios.add(usuario);
    }

    public Usuario getUsuario(String nombre) {
        for (Usuario usuario : listaUsuarios) {
            if (usuario.getNombre().equals(nombre)) {
                return usuario;
            }
        }
        return null;
    }


	
	
//	  public Usuario findBynombre(String nombre) {
//	        return usuario.get(nombre); //o en método get?
//	    }
}
