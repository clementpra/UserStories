<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://d3js.org/d3.v7.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" rel="stylesheet" />
    <title>Relations</title>
</head>

<body>
    <?php include '../navbar.php'; ?>

    <div class="container">
        <div class="card shadow-lg rounded">
            <div class="card-header">
                <h5>Toutes les connaissances</h5>
            </div>
            <div class="card-body">
                <svg width="800" height="600"></svg>
            </div>
        </div>
    </div>







</body>

<style>
    body {
        font-family: Arial, sans-serif;
    }

    svg {
        width: 100%;
        height: 100%;
    }

    .node circle {
        fill: #69b3a2;
        stroke: #555;
        stroke-width: 2px;
    }

    .node text {
        font-size: 12px;
        text-anchor: middle;
        fill: #333;
    }

    .link {
        fill: none;
        stroke: #999;
        stroke-width: 1.5px;
    }

    .link.Famille {

        stroke: #f00;
    }

    <?php

    require_once '/var/www/html/class/relation.php';

    $typesLien = relation::getAllRelationType();

    foreach ($typesLien as $type) {
        echo ".link." . $type['libelle'] . " {
            stroke: #" . substr(md5($type['libelle']), 0, 6) . ";
        }";
    }

    ?>
</style>
<script>
    async function getAllPersonne() {
        response = await fetch('../process/personne_process.php', {
            method: 'POST',
            body: new URLSearchParams({
                'action': 'getAllPersonne'
            }),
        })
        data = await response.json();
        return data;
    }

    async function getAllRelation() {
        response = await fetch('../process/relation_process.php', {
            method: 'POST',
            body: new URLSearchParams({
                'action': 'getAllRelationForGraph'
            }),
        })
        data = await response.json();
        return data;
    }

    async function getAllTypeRelation() {
        response = await fetch('../process/relation_process.php', {
            method: 'POST',
            body: new URLSearchParams({
                'action': 'getAllTypeRelation'
            }),
        })
        data = await response.json();
        return data;
    }

    async function getAllVille() {
        response = await fetch('../process/ville_process.php', {
            method: 'POST',
            body: new URLSearchParams({
                'action': 'getAllVille'
            }),
        })
        data = await response.json();
        return data;
    }

    async function generateGraph() {

        const data = {
            personnes: await getAllPersonne(),
            relations: await getAllRelation(),
            typesLien: await getAllTypeRelation(),
            villes: await getAllVille()
        };

        console.log(data);
        const nodes = data.personnes.map(personne => ({
            id: personne.idPersonne,
            name: `${personne.prenom} ${personne.nom}`
        }));

        console.log(nodes);

        const links = data.relations.map(relation => ({
            source: relation.idPersonne,
            target: relation.idPersonne_1,
            type: data.typesLien.find(t => t.idLien === relation.idLien)?.libelle || "Relation"
        }));

        console.log(links);

        svgElement = document.querySelector('svg');
        infoElement = svgElement.getBoundingClientRect();
        console.log(infoElement);

        // Create SVG canvas
        const svg = d3.select("svg"),
            width = +infoElement.width,
            height = +infoElement.height;

        const simulation = d3.forceSimulation(nodes)
            .force("link", d3.forceLink(links).id(d => d.id).distance(150))
            .force("charge", d3.forceManyBody().strength(-300))
            .force("center", d3.forceCenter(width / 2, height / 2));

        // Draw links
        const link = svg.append("g")
            .selectAll("line")
            .data(links)
            .join("line")
            .attr("class", "link");

        // Draw nodes
        const node = svg.append("g")
            .selectAll("circle")
            .data(nodes)
            .join("g")
            .attr("class", "node");

        node.append("circle")
            .attr("r", 10)
            .call(drag(simulation));

        node.append("text")
            .attr("dy", -15)
            .text(d => d.name);

        // Update simulation
        simulation.on("tick", () => {
            link
                .attr("x1", d => d.source.x)
                .attr("y1", d => d.source.y)
                .attr("x2", d => d.target.x)
                .attr("y2", d => d.target.y)
                .attr("class", d => `link ${d.type}`);

            node.attr("transform", d => `translate(${d.x},${d.y})`);
        });

        // Drag behavior
        function drag(simulation) {
            function dragstarted(event, d) {
                if (!event.active) simulation.alphaTarget(0.3).restart();
                d.fx = d.x;
                d.fy = d.y;
            }

            function dragged(event, d) {
                d.fx = event.x;
                d.fy = event.y;
            }

            function dragended(event, d) {
                if (!event.active) simulation.alphaTarget(0);
                d.fx = null;
                d.fy = null;
            }

            return d3.drag()
                .on("start", dragstarted)
                .on("drag", dragged)
                .on("end", dragended);
        }
    }


    generateGraph();
</script>

</html>