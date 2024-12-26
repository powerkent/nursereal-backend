Feature:
    In order to display children with an IRP
    As an API consumer
    I want to have access to related IRP child data

    Background:
        Given there is a nursery structure with uuid "00000000-0000-0000-0000-000000000001"
        And a manager exists with user "manager@example.com" and password "password123"
        And I am authenticated as "manager@example.com" with password "password123"

    Scenario: I can create a child with an IRP
        Given there is a child with uuid "00000000-0000-0000-0000-000000000001"
        And that child has firstname Quentin
        And that child has lastname Lemoine
        And that child has a birthday on "1993-06-17"
        And that child has a created date "2024-10-11 00:00:00"
        And that child has an updated date "2024-10-11 12:00:00"
        And there is an IRP with name "Allergie aux arachides"
        And that IRP has description "Ne pas donner de plat contenant de l'arachide"
        And that IRP has a created date "2024-10-10 00:00:00"
        And that IRP has a start date "2024-01-01 00:00:00"
        And that IRP has an end date "2025-01-01 00:00:00"
        And that child is linked to IPR with name "Allergie aux arachides"
        When I request "/api/children/00000000-0000-0000-0000-000000000001"
        Then the response code is 200
        And the response body contains JSON:
        """
        {
           "@context":"/api/contexts/Child",
           "@id":"/api/children/00000000-0000-0000-0000-000000000001",
           "@type":"Child",
           "uuid":"00000000-0000-0000-0000-000000000001",
           "id":"@variableType(integer)",
           "firstname":"Quentin",
           "lastname":"Lemoine",
           "birthday":"1993-06-17T00:00:00+00:00",
           "nurseryStructure":"@variableType(object)",
           "createdAt":"2024-10-11T00:00:00+00:00",
           "updatedAt":"2024-10-11T12:00:00+00:00",
           "irp":{
              "@type":"IRPView",
              "@id":"@variableType(string)",
              "name":"Allergie aux arachides",
              "description":"Ne pas donner de plat contenant de l'arachide",
              "createdAt":"2024-10-10T00:00:00+00:00",
              "startAt":"2024-01-01T00:00:00+00:00",
              "endAt":"2025-01-01T00:00:00+00:00"
           },
           "customers":[],
           "treatments":[]
        }
        """
        And the table child has 1 entry with the following values:
            | uuid      | 00000000-0000-0000-0000-000000000001 |
            | firstname | Quentin                              |
            | lastname  | Lemoine                              |
            | irp       | not_null                             |
        And the table irp has 1 entry with the following values:
            | name        | Allergie aux arachides                        |
            | description | Ne pas donner de plat contenant de l'arachide |
            | created_at  | 2024-10-10 00:00:00                           |
            | start_at    | 2024-01-01 00:00:00                           |
            | end_at      | 2025-01-01 00:00:00                           |

    Scenario: I can POST a child with an IRP
        Given the request body is:
        """
        {
            "firstname": "Quentin",
            "lastname": "Lemoine",
            "birthday": "1993-06-17",
            "nurseryStructureUuid": "00000000-0000-0000-0000-000000000001",
            "irp": {
                "name": "Allergie aux acariens",
                "description": "bien nettoyer les pièces",
                "startAt": "2024-01-01 00:00:00",
                "endAt": "2025-01-01 00:00:00"
            }
        }
        """
        And the "Content-Type" request header is "application/ld+json"
        When I request "/api/children" using HTTP POST
        Then the response code is 201
        And the response body contains JSON:
        """
        {
           "@context":"/api/contexts/Child",
           "@id":"@variableType(string)",
           "@type":"Child",
           "uuid":"@variableType(string)",
           "id":"@variableType(integer)",
           "firstname":"Quentin",
           "lastname":"Lemoine",
           "birthday":"1993-06-17T00:00:00+00:00",
           "nurseryStructure":"@variableType(object)",
           "createdAt":"@variableType(string)",
           "irp":{
              "@type":"IRPView",
              "@id":"@variableType(string)",
              "name":"Allergie aux acariens",
              "description":"bien nettoyer les pi\u00e8ces",
              "createdAt":"@variableType(string)",
              "startAt":"2024-01-01T00:00:00+00:00",
              "endAt":"2025-01-01T00:00:00+00:00"
           },
           "customers":[],
           "treatments":[]
        }
        """

    Scenario: I can PUT a child and add an IRP
        Given there is a child with uuid "00000000-0000-0000-0000-000000000001"
        And that child has firstname Quentin
        And that child has lastname Lemoine
        And that child has a birthday on "1993-06-17"
        And that child has a created date "2024-10-11 00:00:00"
        And that child has an updated date "2024-10-11 12:00:00"
        And the request body is:
        """
        {
            "firstname": "Elie",
            "lastname": "Lemoine",
            "birthday": "2024-01-01 00:00:00",
            "nurseryStructureUuid": "00000000-0000-0000-0000-000000000001",
            "irp": {
                "name": "Allergie aux chats",
                "description": "Pas de chat dans la creche",
                "startAt": "2024-01-01 00:00:00",
                "endAt": "2025-01-01 00:00:00"
            }
        }
        """
        And the "Content-Type" request header is "application/ld+json"
        When I request "/api/children/00000000-0000-0000-0000-000000000001" using HTTP PUT
        Then the response code is 200
        And the response body contains JSON:
        """
        {
           "@context":"/api/contexts/Child",
           "@id":"/api/children/00000000-0000-0000-0000-000000000001",
           "@type":"Child",
           "uuid":"00000000-0000-0000-0000-000000000001",
           "id":"@variableType(integer)",
           "firstname":"Elie",
           "lastname":"Lemoine",
           "birthday":"2024-01-01T00:00:00+00:00",
           "nurseryStructure":"@variableType(object)",
           "createdAt":"2024-10-11T00:00:00+00:00",
           "updatedAt":"@variableType(string)",
           "irp":{
              "@type":"IRPView",
              "@id":"@variableType(string)",
              "name":"Allergie aux chats",
              "description":"Pas de chat dans la creche",
              "createdAt":"@variableType(string)",
              "startAt":"2024-01-01T00:00:00+00:00",
              "endAt":"2025-01-01T00:00:00+00:00"
           },
           "customers":[],
           "treatments":[]
        }
        """
        And the table child has 1 entry with the following values:
            | uuid      | 00000000-0000-0000-0000-000000000001 |
            | firstname | Elie                                 |
            | lastname  | Lemoine                              |
            | irp       | not_null                             |
        And the table irp has 1 entry with the following values:
            | name        | Allergie aux chats         |
            | description | Pas de chat dans la creche |
            | created_at  | not_null                   |
            | start_at    | 2024-01-01 00:00:00        |
            | end_at      | 2025-01-01 00:00:00        |

    Scenario: I can PUT a child and remove the IRP
        Given there is a child with uuid "00000000-0000-0000-0000-000000000001"
        And that child has firstname Quentin
        And that child has lastname Lemoine
        And that child has a birthday on "1993-06-17"
        And that child has a created date "2024-10-11 00:00:00"
        And that child has an updated date "2024-10-11 12:00:00"
        And there is an IRP with name "Allergie aux arachides"
        And that IRP has description "Ne pas donner de plat contenant de l'arachide"
        And that IRP has a created date "2024-10-10 00:00:00"
        And that IRP has a start date "2024-01-01 00:00:00"
        And that IRP has an end date "2025-01-01 00:00:00"
        And that child is linked to IPR with name "Allergie aux arachides"
        When I request "/api/children/00000000-0000-0000-0000-000000000001"
        Then the response code is 200
        And the response body contains JSON:
        """
        {
            "irp":{
                "@type":"IRPView",
                "@id":"@variableType(string)",
                "name":"Allergie aux arachides",
                "description":"Ne pas donner de plat contenant de l'arachide",
                "createdAt":"2024-10-10T00:00:00+00:00",
                "startAt":"2024-01-01T00:00:00+00:00",
                "endAt":"2025-01-01T00:00:00+00:00"
           }
        }
        """
        And the request body is:
        """
        {
            "firstname": "Elie",
            "lastname": "Lemoine",
            "birthday": "2024-01-01 00:00:00",
            "nurseryStructureUuid": "00000000-0000-0000-0000-000000000001"
        }
        """
        And the "Content-Type" request header is "application/ld+json"
        When I request "/api/children/00000000-0000-0000-0000-000000000001" using HTTP PUT
        Then the response code is 200
        And the table child has 1 entry with the following values:
            | uuid      | 00000000-0000-0000-0000-000000000001 |
            | firstname | Elie                                 |
            | lastname  | Lemoine                              |
            | irp       | null                                 |
        And the table irp has no entry with the following values:
            | name | Allergie aux arachides |