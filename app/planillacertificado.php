<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class planillacertificado extends Model
{
    protected $fillable = [
        'HOLDING_ASOCIADO','CERTIFICADO','RUT_CONTRATISTA','RAZON_SOCIAL_CONTRATISTA','RUT_MANDANTE','RAZON_SOCIAL_MANDANTE','RUT_TRABAJADOR','NOMBRE_TRABAJADOR','PERIODO_MES','PERIODO_ANIO','ESTADO_TRABAJADOR','LIQUIDO_A_PAGO','TOTAL_HABERES','TOTAL_IMPONIBLE','OBSERVACION_PLANILLA','OBSERVACION_REMUNERACIONAL','OBSERVACION_PREVISIONAL','CONTRATO_CONTRATISTA','PROYECTO_CONTRATISTA','RUT_CONTRATISTA_X_SUBCONTRATISTA','NUMERO_SOLICITUD','OBSERVACION_CONTRATO','DIAS_TRABAJADOS','NUMERO_LOCAL'
    ];
}
