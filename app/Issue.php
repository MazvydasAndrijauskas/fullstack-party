<?php
/**
 * Created by PhpStorm.
 * User: Mazvis
 * Date: 1/19/2018
 * Time: 12:28 AM
 */

namespace App;

use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use Illuminate\Support\Facades\Auth;
use Psy\Util\Json;

const GITHUB_REPO_OWNER = "red";
const GITHUB_REPO_NAME = "red";
const GITHUB_ISSUES_API_URI = "https://api.github.com/repos/%s/%s";
const PER_PAGE = 10;
// Used for create. Did not manage to make it work with token that authentication returns.
const PERSONAL_ACCESS_TOKEN = "b7c9e95c2159937ef868b0e95089ccf439767b5b";

class Issue
{
    private $apiUri;
    private $client;
    private $oAuthToken;

    public function __construct()
    {
        $this->apiUri = sprintf(GITHUB_ISSUES_API_URI, GITHUB_REPO_OWNER, GITHUB_REPO_NAME);
        $this->client = new Client();
        $this->oAuthToken = Auth::user()->token;
    }

    /**
     * @param int $page
     * @return array
     */
    public function get($page)
    {
        /** @var array $issues */
        $issues = [];

        /** @var Response $response */
        $response = $this->client->get("$this->apiUri");
        $issues['total'] = json_decode($response->getBody()->getContents())->open_issues_count;
        /** @var Response $response */
        $response = $this->client->get("$this->apiUri/issues", [
            'headers' => [
                'Authorization' => "token " . $this->oAuthToken
            ],
            'query' => [
                'per_page' => PER_PAGE,
                'page' => $page
            ]
        ]);
        $issues['issues'] = json_decode($response->getBody()->getContents());

        return $issues;
    }

    /**
     * @param int $number
     * @return array
     */
    public function find($number)
    {
        /** @var array $issue */
        $issue = [];
        /** @var Response $response */
        $response = $this->client->get("$this->apiUri/issues/$number", [
            'headers' => [
                'Authorization' => "token " . $this->oAuthToken
            ]
        ]);
        $issue['issue'] = json_decode($response->getBody()->getContents());

        /** @var Response $response */
        $response = $this->client->get("$this->apiUri/issues/$number/comments", [
            'headers' => [
                'Authorization' => "token " . $this->oAuthToken
            ]
        ]);
        $issue['comments'] = json_decode($response->getBody()->getContents());

        return $issue;
    }

    /**
     * @param array $issue
     * @return string
     */
    public function create($issue)
    {
        /** @var Response $response */
        $response = $this->client->post("$this->apiUri/issues", [
            'headers' => [
                'Content-Type' => 'application/json',
                'Authorization' => "token " . PERSONAL_ACCESS_TOKEN
            ],
            'body' => Json::encode($issue)
        ]);

        return json_decode($response->getBody()->getContents());
    }

    /**
     * @param int $number
     * @param array $issue
     */
    public function update($number, $issue)
    {
        /** @var Response $response */
        $response = $this->client->patch("$this->apiUri/issues/$number", [
            'headers' => [
                'Content-Type' => 'application/json',
                'Authorization' => "token " . PERSONAL_ACCESS_TOKEN
            ],
            'body' => Json::encode($issue)
        ]);
    }
}