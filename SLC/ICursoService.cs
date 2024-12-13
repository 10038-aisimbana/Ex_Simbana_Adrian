using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using Entities;

namespace SLC
{
    public interface ICursoService
    {
        Cursos CreateCurso(Cursos curso);
        Cursos RetrieveById(int id);
        bool Update(Cursos curso);
        bool Delete(int id);
        List<Cursos> Filter(string name);
        List<Cursos> RetrieveAll();
    }
}
