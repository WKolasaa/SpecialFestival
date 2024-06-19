function fetchSectionTypes() {
    fetch('/api/PageManagement/getSectionTypes')
        .then(response => {
            if (!response.ok) {
                throw new Error('Failed to fetch section types');
            }
            return response.json();
        })
        .then(data => {
            const selectTypes = document.querySelectorAll('select[name="typeSelector"]');
            selectTypes.forEach(selectType => {
                if (selectType.length === 0)
                    data.forEach(type => {
                        const option = document.createElement('option');
                        option.value = type;
                        option.textContent = type;
                        selectType.appendChild(option);
                    });
            });
        })
        .catch(error => {
            console.error('Error fetching section types:', error);
        });
}

fetchSectionTypes();