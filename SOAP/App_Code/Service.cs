using System;
using System.Collections.Generic;
using System.Linq;
using System.Runtime.Serialization;
using System.ServiceModel;
using System.ServiceModel.Web;
using System.Text;
using BLL;
using Entities;

public class Service : IService
{
    private readonly CursosLogic _cursosLogic = new CursosLogic();

    public Cursos CreateCurso(Cursos curso)
    {
        return _cursosLogic.Create(curso);
    }

    public Cursos RetrieveById(int id)
    {
        return _cursosLogic.RetrieveById(id);
    }

    public bool UpdateCurso(Cursos curso)
    {
        return _cursosLogic.Update(curso);
    }

    public bool DeleteCurso(int id)
    {
        return _cursosLogic.Delete(id);
    }

    public List<Cursos> RetrieveAllCursos()
    {
        return _cursosLogic.RetrieveAll().Cast<Cursos>().ToList();
    }

    public List<Cursos> FilterCursos(string name)
    {
        return _cursosLogic.Filter(name);
    }
}

