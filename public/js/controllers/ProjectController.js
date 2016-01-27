// public/js/controllers/ProjectController.js

angular.module('ProjectController', [])

// inject the Project service into our controller
.controller('ProjectController', function($scope, $http, Project) {
    
    // object to hold all the data for the new project form
    $scope.projects             = {};
    $scope.projectsattached     = {};
    $scope.projectsunattached   = {};    


    // loading variable to show the spinning loading icon
    $scope.loading = true;



    // get all the projects first and bind it to the $scope.projects object
    // use the function we created in our service
    // GET ALL CONTACTS ==============
    Project.get()
        .success(function(data) {
            $scope.projects = data;
            $scope.loading = false;
        });

    Project.getAttached()
        .success(function(data) {
            $scope.projectsattached  = data;
            $scope.loading           = false;
        });   

    Project.getUnattached()
        .success(function(data) {
            $scope.projectsunattached  = data;
            $scope.loading             = false;
        });   
  
    // function to handle submitting the form
    // SAVE A PROJECT ================
    $scope.submitProject = function() {
        $scope.loading = true;

        // save the project. pass in project data from the form
        // use the function we created in our service
        Project.save($scope.projects)
            .success(function(data) {

                // if successful, we'll need to refresh the project list
                Project.get()
                    .success(function(getData) {
                        $scope.projects = getData;
                        $scope.loading = false;
                    });

            })
            .error(function(data) {
                console.log(data);
            });
    };

    // function to handle deleting a project
    // DELETE A PROJECT ====================================================
    $scope.deleteProject = function(id) {
        
        $scope.loading = true; 

        // use the function we created in our service
        Project.destroy(id)
            .success(function(data) {

                // if successful, we'll need to refresh the project list
                Project.get()
                    .success(function(getData) {
                        $scope.projects = getData;
                        $scope.loading = false;
                    });

            });
    };


    $scope.attachProjects = function(data) {       

        $scope.loading = true; 

        console.log(data);

        // use the function we dettach in our service
        Project.attach(  )
            .success(function(data) {

                // if successful, we'll need to refresh the project list
                Project.get()
                    .success(function(getData) {
                        $scope.projects = getData;
                        $scope.loading = false;
                    });

            });
    }



    $scope.dettachProject = function (project_id) {
        $scope.loading = true; 

        // use the function we dettach in our service
        Project.dettach(id)
            .success(function(data) {

                // if successful, we'll need to refresh the project list
                Project.get()
                    .success(function(getData) {
                        $scope.projects = getData;
                        $scope.loading = false;
                    });

            });
    }

});