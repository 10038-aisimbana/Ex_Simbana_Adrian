using System;
using System.Collections.Generic;
using System.Linq;
using System.Runtime.Serialization;
using System.ServiceModel;
using System.ServiceModel.Web;
using System.Text;
using Entities;

[ServiceContract]
public interface IService
{
    [OperationContract]
    Cursos CreateCurso(Cursos curso);

    [OperationContract]
    Cursos RetrieveById(int id);

    [OperationContract]
    bool UpdateCurso(Cursos curso);

    [OperationContract]
    bool DeleteCurso(int id);

    [OperationContract]
    List<Cursos> FilterCursos(string name);

    [OperationContract]
    List<Cursos> RetrieveAllCursos();
}
