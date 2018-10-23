Structure requests as follow:

    http://rmobileapp.co.uk/Controller/Function/

So, for example, if I wanted to access the login endpoint, I would hit the endpoint

    http://rmobileapp.co.uk/Users/Login

To pass data in to a function, make a POST request to it. The API accepts json

    {
      "Username": "hfletcher",
      "Password": "myPassword123",
    }

The API returns JSON in the following format:

    {
      "status": 200,
      "data": "Any data that is returned",
    }
