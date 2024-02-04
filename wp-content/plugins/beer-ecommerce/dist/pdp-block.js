const { registerBlockType } = wp.blocks;
const { apiFetch } = wp;
const { useSelect } = wp.data;

registerBlockType('beer-ecommerce/pdp-block', {
    title: 'Product Detail Page',
    icon: 'beer',
    category: 'common',
    edit: async function () {
        // Lógica de edición del bloque
        // (puedes utilizar la lógica que necesites)

        // Obtener información de stock y precio utilizando la API endpoint
        const fetchData = async () => {
            const productId = 10 /* Obtener el ID del producto desde la URL o donde sea necesario */;
            const response = await apiFetch({ path: `/beer-ecommerce/v1/stock-price/${productId}` });
            const stock = response.stock;
            const price = response.price;
            // Actualizar el formulario de edición con los datos obtenidos
        };

        // Actualizar cada 5 segundos
        const interval = setInterval(fetchData, 5000);

        // Limpieza del intervalo al desmontar el bloque
        return () => clearInterval(interval);
    },
    save: function () {
        // Lógica de guardado del bloque
        // Obtener los parámetros de la URL
        const productId = new URL(window.location.href).pathname.split('-')[0];
        const productBrand = new URL(window.location.href).pathname.split('-')[1];

        // Lógica de guardado del bloque
        // Puedes utilizar productId y productBrand según tus necesidades

        return <div>Guardar PDP aquí</div>;
    },
});
