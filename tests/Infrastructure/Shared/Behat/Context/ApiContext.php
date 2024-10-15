<?php

declare(strict_types=1);

namespace Nursery\Tests\Infrastructure\Shared\Behat\Context;

use Doctrine\ORM\EntityManagerInterface;
use GuzzleHttp\Exception\GuzzleException;
use Imbo\BehatApiExtension\Context\ApiContext as BaseApiContext;
use GuzzleHttp\Client;
use Nursery\Domain\Shared\Model\Agent;
use Nursery\Infrastructure\Shared\Foundry\Factory\AgentFactory;
use Psr\Http\Message\ResponseInterface;
use Ramsey\Uuid\Uuid;
use function sprintf;

class ApiContext extends BaseApiContext
{
    private ?string $token = null;

    public function __construct(private EntityManagerInterface $entityManager)
    {
    }

    public function requestPath(string $path, ?string $method = null): static
    {
        if ($this->token) {
            $this->setRequestHeader('Authorization', sprintf('Bearer %s', $this->token));
        }

        return parent::requestPath($path, $method);
    }

    /**
     * @Given I am authenticated as :email with password :password
     * @throws GuzzleException
     */
    public function iAmAuthenticatedAs(string $email, string $password): void
    {
        $client = new Client(['base_uri' => 'http://server:80']);

        $response = $client->post('/api/login/agent', [
            'json' => [
                'email' => $email,
                'password' => $password,
            ],
        ]);

        $data = json_decode($response->getBody()->getContents(), true);
        $this->token = $data['token'];
    }

    /**
     * @Given an agent exists with email :email and password :password
     */
    public function anAgentExistsWithUsernameAndPassword(string $email, string $password): void
    {
        $agentRepository = $this->entityManager->getRepository(Agent::class);

        $existingAgent = $agentRepository->findOneBy(['email' => $email]);

        if (!$existingAgent) {
            AgentFactory::createOne([
                'uuid' => Uuid::uuid4(),
                'email' => $email,
                'password' => password_hash($password, PASSWORD_BCRYPT),
                'roles' => ['ROLE_AGENT'],
            ]);
        }
    }

    /**
     * @Given a manager exists with email :email and password :password
     */
    public function aManagerExistsWithUsernameAndPassword(string $email, string $password): void
    {
        $agentRepository = $this->entityManager->getRepository(Agent::class);

        $existingAgent = $agentRepository->findOneBy(['email' => $email]);

        if (!$existingAgent) {
            AgentFactory::createOne([
                'uuid' => Uuid::uuid4(),
                'email' => $email,
                'password' => password_hash($password, PASSWORD_BCRYPT),
                'roles' => ['ROLE_MANAGER'],
            ]);
        }
    }

    /**
     * @return string[]
     */
    public function getAuthenticatedHeaders(): array
    {
        return [
            'Authorization' => 'Bearer '.$this->token,
            'Accept' => 'application/json',
        ];
    }

    /**
     * Dump last received response.
     *
     * @Then dump last response
     */
    public function dumpLastResponse(): void
    {
        $this->requireResponse();

        /** @var ResponseInterface $response */
        $response = $this->response;

        dump($response->getStatusCode(), (string) $response->getBody());
    }

    /**
     * Dump last request.
     *
     * @Then dump last request
     */
    public function dumpLastRequest(): void
    {
        $request = $this->request;

        dump($request->getMethod(), $request->getHeaders(), (string) $request->getBody());
    }
}
