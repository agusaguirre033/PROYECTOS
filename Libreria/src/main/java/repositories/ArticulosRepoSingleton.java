package repositories;



import java.util.ArrayList;
import java.util.List;

import models.Articulo;
import repositories.interfaces.ArticuloRepo;

public class ArticulosRepoSingleton implements ArticuloRepo {
	
	private static ArticulosRepoSingleton singleton;
	
	public static ArticulosRepoSingleton getInstance() {
		if(singleton == null) {
			singleton = new ArticulosRepoSingleton();
		}
		return singleton;
	}
	
	private List<Articulo> listaArticulos;

	private ArticulosRepoSingleton() {
		
		this.listaArticulos = new ArrayList<Articulo>();
		Articulo articulo1 = new Articulo("12345", "Los juegos del hambre", "Sonia", 1980, "Santillana", "Novela", 3456, 2);
		Articulo articulo2 = new Articulo("76543", "minions", "Pepe", 1987, "Capelluz", "Acción", 3456, 2);
		this.insert(articulo1);
		this.insert(articulo2);
	}
	
	public void add(Articulo art) {
		
		this.listaArticulos.add(art);
	}
	

	@Override
	public List<Articulo> getAll() {
		return listaArticulos.stream().toList();
		
//		return new ArrayList<Articulo>(this.listaArticulos);
	}

	@Override
	public Articulo findById (int id) {
		return this.listaArticulos.stream()
		.filter((a)-> a.getId() == id ) // filtramos
		.findAny()
		.orElse(null);
	}

	@Override
	public void insert(Articulo articulo) {
		
		int ultimaId = this.listaArticulos.stream() //convierte a stream
				.map(Articulo::getId) // convertir todo en Id
				.max(Integer::compare) // busca el mayor por un dato específico, compara en base a un criterio
				.orElse(0);
		
		articulo.setId(ultimaId + 1); //la nueva Id del articulo
		this.listaArticulos.add(articulo); //inserta el articulo
	}

	@Override
	public void update(Articulo articulo) {
		//por si migramos a BDD.
		
	}

	@Override
	public void delete(int id) {
		this.listaArticulos.removeIf((a) -> a.getId()== id);
		
	}


		
}
