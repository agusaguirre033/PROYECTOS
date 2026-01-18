package repositories.interfaces;

import java.util.List;
import java.io.IOException;

import models.Articulo;

public interface ArticuloRepo {

	public List<Articulo> getAll() throws IOException;
	
	public Articulo findById(int id) throws IOException;
	
	public void insert (Articulo articulo) throws IOException;
	
	public void update (Articulo articulo) throws IOException;
	
	public void delete (int id) throws IOException;
	
}
