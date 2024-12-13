using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using DAL;
using Entities;

namespace BLL
{
    public class CursosLogic
    {
        public Cursos Create(Cursos curso)
        {
            try
            {
                using (var repository = RepositoryFactory.CreateRepository())
                {
                    var existingCurso = repository.Retrieve<Cursos>(c => c.Nombre == curso.Nombre);
                    if (existingCurso == null)
                    {
                        return repository.Create<Cursos>(curso);
                    }
                }
            }
            catch (Exception ex)
            {
              
                throw new Exception("Error al crear el curso.", ex);
            }
            return null;
        }

        public Cursos RetrieveById(int id)
        {
            try
            {
                using (var repository = RepositoryFactory.CreateRepository())
                {
                    return repository.Retrieve<Cursos>(c => c.CursoID == id);
                }
            }
            catch (Exception ex)
            {
                throw new Exception("Error al recuperar el curso por ID.", ex);
            }
        }

        public bool Update(Cursos curso)
        {
            try
            {
                using (var repository = RepositoryFactory.CreateRepository())
                {
                    
                    var existingCurso = repository.Retrieve<Cursos>(c => c.CursoID == curso.CursoID);
                    if (existingCurso != null)
                    {
                        
                        existingCurso.Nombre = curso.Nombre;
                        existingCurso.Descripcion = curso.Descripcion;
                        existingCurso.Creditos = curso.Creditos;

                        
                        return repository.Update<Cursos>(existingCurso);
                    }
                }
            }
            catch (Exception ex)
            {
                throw new Exception("Error al actualizar el curso.", ex);
            }
            return false;
        }

        public bool Delete(int id)
        {
            try
            {
                var curso = RetrieveById(id);
                if (curso != null)
                {
                    using (var repository = RepositoryFactory.CreateRepository())
                    {
                        return repository.Delete<Cursos>(curso);
                    }
                }
            }
            catch (Exception ex)
            {
                throw new Exception("Error al eliminar el curso.", ex);
            }
            return false;
        }

        public List<Cursos> Filter(string name)
        {
            try
            {
                using (var repository = RepositoryFactory.CreateRepository())
                {
                    return repository.Filter<Cursos>(c => c.Nombre.Contains(name));
                }
            }
            catch (Exception ex)
            {
                throw new Exception("Error al filtrar cursos.", ex);
            }
        }

        public List<Cursos> RetrieveAll()
        {
            using (var repository = RepositoryFactory.CreateRepository())
            {
                return repository.Filter<Cursos>(c => c.CursoID > 0).ToList();
            }
        }

    }
}
