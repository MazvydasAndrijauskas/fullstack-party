<?php

namespace App\Http\Controllers;

use App\Issue;
use const App\PER_PAGE;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
const DISPLAY_PAGES = 6;

class IssuesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $issueModel = new Issue();
        /** @var int $current */
        $current = $request->has('page') ? $request->get('page') : 1;
        /** @var array $issues */
        $issues = $issueModel->get($current);
        /** @var array $pagination */
        $pagination = $this->pagination($issues['total'], PER_PAGE, $current);

        return view('issues.index', compact('issues', 'pagination', 'current'));
    }

    /**
     * @param int $number
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show($number)
    {
        $issueModel = new Issue();
        /** @var array $issue */
        $issue = $issueModel->find($number);

        return view('issues.show', $issue);
    }

    public function create()
    {
        return view('issues.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required|max:255',
        ]);

        $issueModel = new Issue();
        $issue = $issueModel->create($request->all());

        return redirect(url("issues/$issue->number"));
    }

    public function edit($number)
    {
        $issueModel = new Issue();
        /** @var array $issue */
        $issue = $issueModel->find($number);

        if (Auth::user()->name != $issue['issue']->user->login) {
            return redirect("issues/$number")->withErrors("You are not the owner of this issue");
        }

        return view('issues.edit', $issue);
    }

    public function update($number, Request $request)
    {
        $this->validate($request, [
            'title' => 'required|max:255',
        ]);

        $issueModel = new Issue();
        $issueModel->update($number, $request->all());

        return redirect(url("issues/$number"));
    }

    /**
     * @param int $data
     * @param int|null $limit
     * @param int|null $current
     * @return array
     */
    private function pagination($data, $limit = null, $current = null)
    {
        $result = array();

        if (isset($data, $limit) === true) {
            $result = range(1, ceil($data / $limit));

            if (isset($current) === true) {
                if (($adjacents = floor(DISPLAY_PAGES / 2) * 2 + 1) >= 1) {
                    $result = array_slice($result, max(0, min(count($result) - DISPLAY_PAGES, (int)$current - ceil($adjacents / 2))), DISPLAY_PAGES);
                }
            }
        }

        return $result;
    }
}
