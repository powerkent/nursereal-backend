Feature:
    In order to display customers
    As an API consumer
    I want to have access to related customer data

    Background:
        Given there is a nursery structure with uuid "00000000-0000-0000-0000-000000000001"
        And a manager exists with user "manager@example.com" and password "password123"
        And I am authenticated as "manager@example.com" with password "password123"

    Scenario: I can create a customer
        Given there is a customer with uuid "00000000-0000-0000-0000-000000000001"
        And that customer has firstname Quentin
        And that customer has lastname Lemoine
        And that customer has an email "quentin.lemoine62580@gmail.com"
        And that customer has a phone number 0606060606
        And that customer has a password "pass123"
        And that customer has a created date "2024-10-11 00:00:00"
        When I request "/api/customers?page=1"
        Then the response code is 200
        And the response body contains JSON:
        """
        {
           "@context":"/api/contexts/Customer",
           "@id":"/api/customers",
           "@type":"Collection",
           "totalItems":1,
           "member":[
              {
                 "@id":"/api/customers/00000000-0000-0000-0000-000000000001",
                 "@type":"Customer",
                 "uuid":"00000000-0000-0000-0000-000000000001",
                 "firstname":"Quentin",
                 "lastname":"Lemoine",
                 "email":"quentin.lemoine62580@gmail.com",
                 "phoneNumber":"0606060606",
                 "children":[]
              }
           ]
        }
        """
        And the table customer has 1 entry with the following values:
            | uuid         | 00000000-0000-0000-0000-000000000001 |
            | id           | not_null                             |
            | firstname    | Quentin                              |
            | lastname     | Lemoine                              |
            | email        | quentin.lemoine62580@gmail.com       |
            | phone_number | 0606060606                            |
            | password     | pass123                              |
            | created_at   | 2024-10-11 00:00:00                  |

    Scenario: I can POST a customer and check if the password has been hashed
        Given there is a child with uuid "00000000-0000-0000-0000-000000000001"
        And that child has firstname Elie
        And that child has lastname Lemoine
        And that child has a birthday on "1993-06-17"
        And that child has a created date "2024-10-11 00:00:00"
        And that child is linked to nursery structure with uuid "00000000-0000-0000-0000-000000000001"
        And the request body is:
        """
        {
            "firstname": "Quentin",
            "lastname": "Lemoine",
            "email": "parent@example.com",
            "user": "parent@example.com",
            "password": "pass123",
            "phoneNumber": "0606060606",
            "children": [
                {
                    "uuid": "00000000-0000-0000-0000-000000000001"
                }
            ]
        }
        """
        And the "Content-Type" request header is "application/ld+json"
        When I request "/api/customers" using HTTP POST
        Then the response code is 201
        And the response body contains JSON:
        """
        {
           "@context":"/api/contexts/Customer",
           "@id":"@variableType(string)",
           "@type":"Customer",
           "uuid":"@variableType(string)",
           "firstname":"Quentin",
           "lastname":"Lemoine",
           "email":"parent@example.com",
           "user": "parent@example.com",
           "phoneNumber":"0606060606",
           "children":[
              {
                 "@type":"ChildView",
                 "@id":"@variableType(string)",
                 "uuid":"00000000-0000-0000-0000-000000000001",
                 "firstname":"Elie",
                 "lastname":"Lemoine",
                 "birthday":"1993-06-17T00:00:00+00:00",
                 "createdAt":"2024-10-11T00:00:00+00:00",
                 "treatments":[]
              }
           ]
        }
        """
        And the table customer has 1 entry with the following values:
            | uuid         | not_null           |
            | id           | not_null           |
            | firstname    | Quentin            |
            | lastname     | Lemoine            |
            | email        | parent@example.com |
            | phone_number | 0606060606          |
            | password     | not_null           |
            | created_at   | not_null           |
        And the table customer has no entry with the following values:
            | firstname    | Quentin            |
            | lastname     | Lemoine            |
            | email        | parent@example.com |
            | phone_number | 0606060606          |
            | password     | pass123            |

    Scenario: I can GET a customer
        Given there is a customer with uuid "00000000-0000-0000-0000-000000000001"
        And that customer has firstname Quentin
        And that customer has lastname Lemoine
        And that customer has an email "quentin.lemoine62580@gmail.com"
        And that customer has a phone number 0606060606
        And that customer has a password "pass123"
        And that customer has a created date "2024-10-11 00:00:00"
        When I request "/api/customers/00000000-0000-0000-0000-000000000001"
        Then the response code is 200
        And the response body contains JSON:
        """
        {
           "@context":"\/api\/contexts\/Customer",
           "@id":"\/api\/customers\/00000000-0000-0000-0000-000000000001",
           "@type":"Customer",
           "uuid":"00000000-0000-0000-0000-000000000001",
           "firstname":"Quentin",
           "lastname":"Lemoine",
           "email":"quentin.lemoine62580@gmail.com",
           "phoneNumber":"0606060606",
           "children":[]
        }
        """
        And the table customer has 1 entry with the following values:
            | uuid         | 00000000-0000-0000-0000-000000000001 |
            | id           | not_null                             |
            | firstname    | Quentin                              |
            | lastname     | Lemoine                              |
            | email        | quentin.lemoine62580@gmail.com       |
            | phone_number | 0606060606                           |
            | password     | pass123                              |
            | created_at   | 2024-10-11 00:00:00                  |

    Scenario: I can PUT a customer
        Given there is a child with uuid "00000000-0000-0000-0000-000000000001"
        And that child has firstname Elie
        And that child has lastname Lemoine
        And that child has a birthday on "1993-06-17"
        And that child has a created date "2024-10-11 00:00:00"
        And there is a customer with uuid "00000000-0000-0000-0000-000000000001"
        And that customer has firstname Quentin
        And that customer has lastname Lemoine
        And that customer has an email "quentin.lemoine62580@gmail.com"
        And that customer has a phone number 0606060606
        And that customer has a password "pass123"
        And that customer has a created date "2024-10-11 00:00:00"
        And the request body is:
        """
        {
           "firstname":"Henri",
           "lastname":"Bernard",
           "email":"parent@example.com",
           "user":"parent@example.com",
           "password":"password",
           "phoneNumber":"0707070707",
           "children":[
               {
                   "uuid":"00000000-0000-0000-0000-000000000001"
               }
           ]
        }
        """
        And the "Content-Type" request header is "application/ld+json"
        When I request "/api/customers/00000000-0000-0000-0000-000000000001" using HTTP PUT
        Then the response code is 200
        And the response body contains JSON:
        """
        {
           "@context":"/api/contexts/Customer",
           "@id":"/api/customers/00000000-0000-0000-0000-000000000001",
           "@type":"Customer",
           "uuid":"00000000-0000-0000-0000-000000000001",
           "firstname":"Henri",
           "lastname":"Bernard",
           "email":"parent@example.com",
           "user":"parent@example.com",
           "phoneNumber":"0707070707",
           "children":[
              {
                 "@type":"ChildView",
                 "@id":"@variableType(string)",
                 "uuid":"00000000-0000-0000-0000-000000000001",
                 "firstname":"Elie",
                 "lastname":"Lemoine",
                 "birthday":"1993-06-17T00:00:00+00:00",
                 "createdAt":"2024-10-11T00:00:00+00:00",
                 "treatments":[]
              }
           ]
        }
        """
        And the table customer has 1 entry with the following values:
            | uuid         | 00000000-0000-0000-0000-000000000001 |
            | id           | not_null                             |
            | firstname    | Henri                                |
            | lastname     | Bernard                              |
            | email        | parent@example.com                   |
            | phone_number | 0707070707                           |
            | password     | not_null                             |
            | created_at   | not_null                             |
        And the table customer has no entry with the following values:
            | uuid         | 00000000-0000-0000-0000-000000000001 |
            | password     | password                             |
        And the table customer_child has 1 entry with the following values:
            | customer_id | not_null |
            | child_id    | not_null |

    Scenario: I can delete a customer
        Given there is a customer with uuid "00000000-0000-0000-0000-000000000001"
        And that customer has firstname Quentin
        And that customer has lastname Lemoine
        And that customer has an email "quentin.lemoine62580@gmail.com"
        And that customer has a phone number 0606060606
        And that customer has a password "pass123"
        And that customer has a created date "2024-10-11 00:00:00"
        When I request "/api/customers/00000000-0000-0000-0000-000000000001"
        Then the response code is 200
        When I request "/api/customers/00000000-0000-0000-0000-000000000001" using HTTP DELETE
        Then the response code is 204
        When I request "/api/customers/00000000-0000-0000-0000-000000000001"
        Then the response code is 404
        And the table customer has no entry with the following values:
            | uuid       | 00000000-0000-0000-0000-000000000001 |