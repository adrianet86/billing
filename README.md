#### 1. Description of the proposed solution
RESTFUL Api developed in PHP running on a docker service in a swarm cluster.
The Api endpoints should follow the format below.
    
    POST /api/billing/{billing_id}/payment/{payment_method}

I followed domain driven design and hexagonal architecture to code this solution.

#### 2. Entity-relationship diagram for your proposed solution

I have only create 2 entities with id as attribute and relation 1-1:

**Billing and PaymentDetails**

I think no more info is required to show a proper solution to this problem.

#### 4. Description of the proposed AWS infrastructure
The number of servers and services running depends on traffic and resources demand, but as I don't know the details
here you have a proposal.
As mentioned in first point, I would create a docker swarm cluster with 1 leader, 2 managers and 2 workers for the PHP service.
I would deploy the application over 5 EC2 instances t2.medium with high availability (multi AZ), configured with 
auto scaling policy to increase the instances on a major CPU demand and a minimum of 5 instances running.
For the message system used to publish Events (like BillingPaid) and notify other services I would use RabbitMQ. There are
AMIs available to create instances to run RabbitMQ (this instance with multi AZ and scaling policies too).
Finally I would use a PostgreSQL RDS (db.t2.large) to store the billings and payment details. This RDS should have as well 
High availability and scaling policies.

#### Improvements
The Billing->block() & Billing->unblock() methods are not consistence, I should persists the entity, or block the DB row, or think something else 
to solve this problem. The main idea is create a method to solve the domain requirement.

The LogRepository is very basic, I should create an entity with attributes to store more detailed information.

I would use Symfony as a framework and its [service container](https://symfony.com/doc/current/service_container.html)
instead of instantiate each object with all the dependencies.