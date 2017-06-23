class Dashboard {
    constructor() {
        this.bindEvents();
    }

    bindEvents() {
        $('.grid-stack').on('change', () => this.updateNodes());
    }

    updateNodes() {
        $('.grid-stack').animate({ 'opacity': 0.3 });

        var data = [];
        var nodes = $('.grid-stack').data('gridstack').grid.nodes;

        for (var i = 0; i < nodes.length; i++) {
            var node = nodes[i];

            data.push({
                id: parseInt(node.id),
                width: node.width,
                height: node.height,
                x: node.x,
                y: node.y,
            });
        }

        $.post(config.base_url + '/dashboard/update-nodes', { nodes: data })
            .then(() => {
                $('.grid-stack').animate({ 'opacity': 1 });
            });
    }
}

export default Dashboard;
