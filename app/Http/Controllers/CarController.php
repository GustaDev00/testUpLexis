<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\Article;

class CarController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('site.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        $domains = Article::orderBy('url', 'ASC');
        dd($domains);
        // return view('site.index', ['slug' => $slug]);
    }

    public function import()
    {
        $article = Article::orderBy('nome_veiculo', 'DESC', "%{$_POST['sea']}%")->where('nome_veiculo', 'LIKE', "%{$_POST['sea']}%")->paginate(10);
        if (count($article) < 1) {
            include_once "../simple_html_dom.php";
            $html = file_get_html('https://www.questmultimarcas.com.br/estoque?termo=' . $_POST['sea']);
            if ($html->find('article.clearfix') == false) {
                return view('site.index', ['boolean' => false]);
            } else {
                $x = 0;
                $w = 6;
                for ($i = 0; $i < count($html->find('article.clearfix img')); $i++) {
                    $count = $i + 1;
                    $cars[$i]['img_veiculo'] = $html->find('article.clearfix img')[$i]->src;
                    $cars[$i]['nome_veiculo'] = $html->find('article.clearfix div.card__inner h2 a')[$i]->innertext;
                    $cars[$i]['link'] = $html->find('article.clearfix div.card__inner h2 a')[$i]->href;

                    while ($x < ($w * $count)) {
                        $cars[$i][] = $html->find('article.clearfix div.card__inner div.card__desc_wrap ul li span.card-list__info')[$x]->innertext;
                        $x++;
                    }

                    $article = Article::create([
                        'nome_veiculo' => $cars[$i]['nome_veiculo'],
                        'img_veiculo' => $cars[$i]['img_veiculo'],
                        'link' => $cars[$i]['link'],
                        'ano' => $cars[$i][0],
                        'quilometragem' => $cars[$i][1],
                        'combustivel' => $cars[$i][2],
                        'cambio' => $cars[$i][3],
                        'portas' => $cars[$i][4],
                        'cor' => $cars[$i][5],
                    ]);

                    if ($article->save()) {
                        $saved = true;
                    } else {
                        $saved = false;
                    }
                }
            }
        } else {
            return view('site.index', [
                'data' => $article,
                'boolean' => true
            ]);
        }

        if($saved){
            $article = Article::orderBy('nome_veiculo', 'DESC', "%{$_POST['sea']}%")->where('nome_veiculo', 'LIKE', "%{$_POST['sea']}%")->paginate(10);
            return view('site.index', [
                'data' => $article,
                'boolean' => true
            ]);
        }else{
            return view('site.index', ['boolean' => false]);
        }

    }
}
