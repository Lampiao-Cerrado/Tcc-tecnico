<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class ConfiguracaoSite extends Model
{
    protected $table = 'configuracoes_site';
    protected $fillable = ['titulo_missao','paragrafo1','paragrafo2','imagem_hero'];
}
